<?php
namespace backend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\models\User;
use common\models\UserPhone;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $phone_input;
    public $password;
    public $status;
    public $roles;

    private $model;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['phone', 'phone_input'], 'required'],
            [['phone', 'phone_input'], 'string'],
            [['phone', 'phone_input'], PhoneInputValidator::className()],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
//            ['email', 'email'],
            ['email', 'unique', 'targetClass'=> User::className(), 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id'=>$this->getModel()->id]]);
                }
            }],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],

            [['status'], 'integer'],
            [['roles'], 'each',
                'rule' => ['in', 'range' => ArrayHelper::getColumn(
                    Yii::$app->authManager->getRoles(),
                    'name'
                )]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('backend', 'Username'),
            'email' => Yii::t('backend', 'E-mail'),
            'phone' => Yii::t('backend', 'Phone'),
            'phone_input' => Yii::t('backend', 'Phone'),
            'status' => Yii::t('backend', 'Status'),
            'password' => Yii::t('backend', 'Password'),
            'roles' => Yii::t('backend', 'Roles'),
        ];
    }

    /**
     * @param User $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->phone = $model->phone;
        $this->phone_input = $model->phone;
        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        return $this->model;
    }

    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save($post)
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->phone = $this->phone;
            $model->status = $this->status;
            if ($this->password) {
                $model->setPassword($this->password);
            }
            if (!$model->save()) {
                throw new Exception('Model not saved');
            }
            if(!empty($post['add_phones'])){
                $this->saveAddPhones($post, $model->getId());
            }
            if ($isNewRecord) {
                $model->afterSignup();
            }
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            return !$model->hasErrors();
        }
        return null;
    }

    public function saveAddPhones($post, $id)
    {
        foreach ($post['add_phones'] as $key=>$value){
            if(empty($post['add_phones_id'][$key])){
                $model = new UserPhone();
            }else{
                $model = UserPhone::findOne($post['add_phones_id'][$key]);
            }
            if(empty($value)){
                $model->delete();
            }else{
                $model->user_id = $id;
                $model->phone = $value;
                $model->save();
            }
        }
    }

}
