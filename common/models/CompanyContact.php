<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%company_contact}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property double $lat
 * @property double $lng
 * @property string $working_mode
 * @property string $managers
 * @property string $email
 * @property string $sales_department
 * @property string $purchase_department
 * @property integer $isMain
 * @property integer $status
 * @property integer $sorting
 */
class CompanyContact extends \yii\db\ActiveRecord
{
    const IS_MAIN_TRUE = 1;
    const STATUS_ACTIVE = 1;

    /**
     * @var string
     */
//    public $phones;

    /**
     * @var string
     */
//    public $name;

    /**
     * @var double
     */
//    public $lat;

    /**
     * @var double
     */
//    public $lng;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%company_contact}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['address', 'email'], 'required'],
            [['name', 'address', 'working_mode', 'managers', 'sales_department', 'purchase_department', 'email', 'lat', 'lng'], 'string', 'max' => 255],
            [['isMain', 'status', 'sorting'], 'integer'],
            [['isMain', 'sorting', 'status'], 'default', 'value' => 0],
            [['email'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['isMain', 'existMain'],
        ];
    }

    public function existMain()
    {
        $mainCompanyContact = CompanyContact::findOne(['isMain' => self::IS_MAIN_TRUE]);
        if ($mainCompanyContact && $mainCompanyContact->id != $this->id && $this->isMain == self::IS_MAIN_TRUE) {
            $this->addError('isMain', Yii::t('backend', 'Main office has been already exist.'));
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('backend', 'ID'),
            'name'    => Yii::t('backend', 'name'),
            'address' => Yii::t('backend', 'Address'),
            'lat'     => Yii::t('backend', 'lat'),
            'lng'     => Yii::t('backend', 'lng'),
            'working_mode' => Yii::t('backend', 'Working mode'),
            'managers' => Yii::t('backend', 'Managers'),
            'email' => Yii::t('backend', 'Email'),
            'sales_department' => Yii::t('backend', 'Sales department'),
            'purchase_department' => Yii::t('backend', 'Purchase department'),
            'isMain' => Yii::t('backend', 'Main office'),
            'status' => Yii::t('backend', 'Status'),
            'sorting' => Yii::t('backend', 'Sorting'),
        ];
    }

    /**
     * @return \common\models\query\CompanyContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CompanyContactQuery(get_called_class());
    }
}
