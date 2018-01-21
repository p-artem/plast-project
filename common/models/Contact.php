<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $time
 * @property string $message
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 * @property string $subject
 */
class Contact extends \yii\db\ActiveRecord
{
    const TYPE_CALLBACK = 1;
    const TYPE_SUBSCRIBE = 2;
    const TYPE_REVIEW = 3 ;
    const TYPE_CONTACT_US = 4;

    const STATUS_WAITED = 0;
    const STATUS_ACTIVED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message','email','subject'], 'string'],
            [['type', 'status'], 'integer'],
            [['name', 'surname', 'phone', 'time'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'name' => Yii::t('backend', 'Name'),
            'surname' => Yii::t('backend', 'Surname'),
            'fullName' => Yii::t('backend', 'Full Name'),
            'phone' => Yii::t('backend', 'Phone'),
            'email' => Yii::t('backend', 'E-mail'),
            'time' => Yii::t('backend', 'Time'),
            'message' => Yii::t('backend', 'Message'),
            'subject' => Yii::t('backend', 'Subject'),
            'type' => Yii::t('backend', 'Type'),
            'status' => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ContactQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->surname  . ' ' . $this->name;
    }
}
