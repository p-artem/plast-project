<?php
namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\modules\user\Module;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\Url;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $phone;
    /**
     * @var
     */
    public $phone_input;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;
    /**
     * @var
     */
    public $password_confirm;
    /**
     * @var
     */
    public $agreement;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
//            ['username', 'unique',
//                'targetClass'=>User::className(),
//                'message' => Yii::t('user', 'This username has already been taken.')
//            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['phone', 'phone_input'], 'required'],
            [['phone', 'phone_input'], 'string'],
            [['phone', 'phone_input'], PhoneInputValidator::className()],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass'=> User::className(),
                'message' => Yii::t('user', 'This email address has already been taken.')
            ],

            [['password', 'password_confirm'], 'required'],
            [['password', 'password_confirm'], 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            ['agreement', 'compare', 'compareValue' => 1, 'message' => Yii::t('user', 'You must accept the user agreement.')],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'=>Yii::t('user', 'Username'),
            'phone_input'=>Yii::t('user', 'Phone'),
            'phone'=>Yii::t('user', 'Phone'),
            'email'=>Yii::t('user', 'E-mail'),
            'password'=>Yii::t('user', 'Password'),
            'password_confirm' => Yii::t('user', 'Confirm Password')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $shouldBeActivated = $this->shouldBeActivated();
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if(!$user->save()) {
                throw new Exception("User couldn't be saved");
            };
            $user->afterSignup();
            if ($shouldBeActivated) {
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_ACTIVATION,
                    Time::SECONDS_IN_A_DAY
                );
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('user', 'Activation email'),
                    'view' => 'activation',
                    'to' => $this->email,
                    'params' => [
                        'url' => Url::to(['/user/activation', 'token' => $token->token], true)
                    ]
                ]));
            } else {
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('user', 'Sign Up email'),
                    'view' => 'signup',
                    'to' => $this->email,
                    'params' => [
                        'user' => $user
                    ]
                ]));
            }
            return $user;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function shouldBeActivated()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule) {
            return false;
        } elseif ($userModule->shouldBeActivated) {
            return true;
        } else {
            return false;
        }
    }
}
