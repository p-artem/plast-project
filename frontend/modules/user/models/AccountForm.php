<?php
namespace frontend\modules\user\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\JsExpression;

/**
 * Account form
 */
class AccountForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $phone_input;
//    public $birthday;
//    public $city;
    public $password;
    public $password_confirm;

    /**
     * @var $user User
     */
    private $user;

    public function init()
    {
        parent::init();
        $this->setUser(Yii::$app->user->identity);
    }

    public function setUser($user)
    {
        $this->user = $user;
        $this->phone = $user->phone;
        $this->phone_input = $user->phone;
        $this->email = $user->email;
        $this->username = $user->username;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
//            ['username', 'unique',
//                'targetClass' => User::className(),
//                'message' => Yii::t('user', 'This username has already been taken.'),
//                'filter' => function ($query) {
//                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
//                }
//            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['phone', 'phone_input'], 'required'],
            [['phone', 'phone_input'], 'string'],
            [['phone', 'phone_input'], PhoneInputValidator::className()],

            ['email', 'filter', 'filter' => 'trim'],
//            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('site', 'This email has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['password', 'string'],
            [
                'password_confirm',
                'required',
                'when' => function($model) {
                    return !empty($model->password);
                },
                'whenClient' => new JsExpression("function (attribute, value) {
                    return $('#accountform-password').val().length > 0;
                }")
            ],

            ['password_confirm', 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'FIO'),
            'phone_input'=>Yii::t('user', 'Phone'),
            'phone'=>Yii::t('user', 'Phone'),
            'email' => Yii::t('user', 'E-mail'),
            'password' => Yii::t('user', 'Password'),
            'password_confirm' => Yii::t('user', 'Confirm Password')
        ];
    }

    public function save()
    {
        $this->user->username = $this->username;
//        $this->user->email = $this->email;
        $this->user->phone = $this->phone;
        if ($this->password) {
            $this->user->setPassword($this->password);
        }
        return $this->user->save();
    }
}
