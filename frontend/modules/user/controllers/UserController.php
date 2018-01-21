<?php

namespace frontend\modules\user\controllers;

use common\base\MultiModel;
use frontend\models\search\OrderSearch;
use frontend\modules\user\models\AccountForm;
use Yii;
use yii\web\Controller;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UserController
 * @package frontend\modules\user\controllers
 */
class UserController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/user']);
                        }
                    ],
                    [
                        'actions' => ['logout', 'profile', 'order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $accountForm = new AccountForm();

        $model = new MultiModel([
            'models' => [
                'account' => $accountForm,
                'profile' => Yii::$app->user->identity->userProfile
            ]
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->getModel('account')->phone_input = $model->getModel('account')->phone;
            if ($model->save()) {
                $locale = $model->getModel('profile')->locale;
                Yii::$app->session->setFlash('forceUpdateLocale');
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::t('user', 'Your account has been successfully saved', [], $locale)
                ]);
                return $this->refresh();
            }
        }

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('profile', compact('model', 'dataProvider', 'searchModel'));
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrder($id)
    {
        $order = Yii::$app->user->identity->getOrders()->andWhere(['id'=>$id])->one();
        if (!$order) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }

        return $this->render('order', compact('order'));
    }

    /**
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $model = new LoginForm();
        if ($request->isPost
            && $model->load($request->post())
            && $model->login()
        ) {
            return $this->redirect($request->referrer);
        }
//        if ($request->isAjax) {
//            return $this->renderAjax('login', ['model' => $model]);
//        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return string|Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
          $model->phone_input = $model->phone;
            $user = $model->signup();
            if ($user) {
                if ($model->shouldBeActivated()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t(
                            'user',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class'=>'alert-success']
                    ]);
                } else {
                    Yii::$app->getUser()->login($user);
                }
                return $this->render('signup-success');
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body' => Yii::t('user', 'Your account has been successfully activated.'),
            'options' => ['class'=>'alert-success']
        ]);

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('user', 'Check your email for further instructions.'),
                    'options'=>['class'=>'alert-success']
                ]);

                return $this->redirect('login');
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('user', 'Sorry, we are unable to reset password for email provided.'),
                    'options'=>['class'=>'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body'=> Yii::t('user', 'New password was saved.'),
                'options'=>['class'=>'alert-success']
            ]);
            return $this->redirect('login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $user = User::find()->where([
            'oauth_client'=>$client->getName(),
            'oauth_client_user_id'=>ArrayHelper::getValue($attributes, 'id')
        ])
            ->one();
        if (!$user) {
            $user = new User();
            $user->scenario = 'oauth_create';
            $user->username = ArrayHelper::getValue($attributes, 'login');
            $user->email = ArrayHelper::getValue($attributes, 'email');
            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                $profileData = [];
                if ($client->getName() === 'facebook') {
                    $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
                    $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
                }
                $user->afterSignup($profileData);
                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view' => 'oauth_welcome',
                    'params' => ['user'=>$user, 'password'=>$password],
                    'subject' => Yii::t('user', '{app-name} | Your login information', ['app-name'=>Yii::$app->name]),
                    'to' => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-success'],
                            'body'=>Yii::t('user', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                'app-name'=>Yii::$app->name
                            ])
                        ]
                    );
                }

            } else {
                // We already have a user with this email. Do what you want in such case
                if ($user->email && User::find()->where(['email'=>$user->email])->count()) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-danger'],
                            'body'=>Yii::t('user', 'We already have a user with email {email}', [
                                'email'=>$user->email
                            ])
                        ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options'=>['class'=>'alert-danger'],
                            'body'=>Yii::t('user', 'Error while oauth process.')
                        ]
                    );
                }

            };
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return true;
        } else {
            throw new Exception('OAuth error');
        }
    }
}
