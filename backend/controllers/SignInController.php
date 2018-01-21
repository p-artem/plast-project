<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 8/2/14
 * Time: 11:20 AM
 */

namespace backend\controllers;

use backend\controllers\actions\RemoveImageAction;
use backend\models\LoginForm;
use backend\models\AccountForm;
use common\models\UserProfile;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SignInController extends Controller
{

    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new UserProfile(),
            ],
        ];
    }


    public function actionLogin()
    {
        $this->layout = 'base';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->userProfile;
        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options'=>['class'=>'alert-success'],
                'body'=>Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
            ]);
            return $this->refresh();
        }
        return $this->render('profile', ['model'=>$model]);
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        $model->email = $user->email;
        $model->phone = $user->phone;
        $model->phone_input = $user->phone;
        if ($model->load(Yii::$app->request->post())){
            $model->phone_input = $model->phone;
            if ($model->validate()) {
                $user->username = $model->username;
                $user->email = $model->email;
                $user->phone = $model->phone;
                if ($model->password) {
                    $user->setPassword($model->password);
                }
                $user->save();
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::t('backend', 'Your account has been successfully saved')
                ]);
                return $this->refresh();
            }
        }
        return $this->render('account', ['model'=>$model]);
    }
}
