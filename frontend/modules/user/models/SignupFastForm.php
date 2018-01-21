<?php
namespace frontend\modules\user\models;

use common\models\User;
use frontend\modules\user\Module;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * SignupFast form
 *
 * @property string $username
 * @property string $phone
 * @property string $phone_input
 * @property string $email
 */
class SignupFastForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var string
     */
    public $phone_input;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    protected $_formName;

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
//            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass'=> User::className(),
                'message' => Yii::t('user', 'This email address has already been taken.')
            ],

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
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $shouldBeActivated = $this->shouldBeActivated();
        if (!$user = User::findByEmail($this->phone)) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->phone;
            $user->phone = $this->phone;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword(Yii::$app->getSecurity()->generateRandomString());
            if (!$user->save(false)) {
                throw new Exception("User couldn't be saved");
            };
            $user->afterSignup();
//            if ($shouldBeActivated) {
//                $token = UserToken::create(
//                    $user->id,
//                    UserToken::TYPE_ACTIVATION,
//                    Time::SECONDS_IN_A_DAY
//                );
//                Yii::$app->commandBus->handle(new SendEmailCommand([
//                    'subject' => Yii::t('user', 'Activation email'),
//                    'view' => 'activation',
//                    'to' => $this->email,
//                    'params' => [
//                        'url' => Url::to(['/user/activation', 'token' => $token->token], true)
//                    ]
//                ]));
//            }
        }
        return $user;
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

    /**
     * @return string
     */
    public function formName()
    {
        if (empty($this->_formName)){
            $this->_formName = parent::formName();
        }
        return $this->_formName;
    }

    /**
     * @param $suffix
     */
    public function setFormName($suffix)
    {
        $this->_formName = implode('-', [parent::formName(), $suffix]);
    }
}
