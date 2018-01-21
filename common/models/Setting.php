<?php

namespace common\models;

use Yii;
use yiidreamteam\upload\FileUploadBehavior;
use yiidreamteam\upload\ImageUploadBehavior;
use yii\caching\TagDependency;
/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $short
 * @property string $text
 * @property string $logo
 * @property string $main_image
 * @property string $main_phone
 * @property string $phone
 * @property string $email
 * @property string $main_email
 * @property string $address
 * @property string $price
 * @property string $google_location
 * @property string $coordinate_x
 * @property string $coordinate_y
 * @property integer $status_site
 */
class Setting extends \yii\db\ActiveRecord
{
    const STATUS_SITE_ACTIVE = 1;
    const STATUS_SITE_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status_site'], 'required'],
            [['short', 'text', 'address'], 'string'],
            [['status_site'], 'integer'],
            [['name', 'main_phone', 'phone', 'email', 'main_email', 'coordinate_x', 'coordinate_y'], 'string', 'max' => 255],
            [['google_location'], 'string', 'max' => 512],
            [['logo', 'main_image'], 'file', 'extensions' => 'jpeg, gif, png'],
            [
                ['price'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => ['xls', 'xlsx', 'pdf'],//'xml, yml, csv',
                'checkExtensionByMimeType' => false
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'logo' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'logo',
                'filePath' => '@images/[[model]]/logo.[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/logo.[[extension]]',
            ],
            'main_image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'main_image',
                'filePath' => '@images/[[model]]/main_image.[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/main_image.[[extension]]',
            ],
            'price' => [
                'class' => FileUploadBehavior::className(),
                'attribute' => 'price',
                'filePath' => '@storage/web/source/files/price/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@storageUrl/web/source/files/price/[[model]]/[[pk]].[[extension]]',
            ],
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
            'short' => Yii::t('backend', 'Short'),
            'text' => Yii::t('backend', 'Text'),
            'logo' => Yii::t('backend', 'Logo'),
            'price' => Yii::t('backend', 'Price'),
            'main_image' => Yii::t('backend', 'Main Image'),
            'main_phone' => Yii::t('backend', 'Main Phone'),
            'phone' => Yii::t('backend', 'Phone'),
            'email' => Yii::t('backend', 'Email'),
            'main_email' => Yii::t('backend', 'Main Email'),
            'address' => Yii::t('backend', 'Address'),
            'google_location' => Yii::t('backend', 'Google Location'),
            'coordinate_x' => Yii::t('backend', 'Coordinate X'),
            'coordinate_y' => Yii::t('backend', 'Coordinate Y'),
            'status_site' => Yii::t('backend', 'Status Site'),
        ];
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getImageUrl($name = 'logo')
    {
        /* @var $imageUploadBehavior ImageUploadBehavior */
        $imageUploadBehavior = $this->getBehavior($name);
        if ($imageUrl = $imageUploadBehavior->getImageFileUrl($name)){
            if (($timestamp = @filemtime($imageUploadBehavior->getUploadedFilePath($name))) > 0) {
                $imageUrl .= "?_=$timestamp";
            }
        }
        return $imageUrl;
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        TagDependency::invalidate(Yii::$app->frontendCache, 'app-settings-' . $this->id);
    }

    /**
     * @return bool
     */
    public function isSiteOff(){
        return $this->status_site == self::STATUS_SITE_INACTIVE;
    }

    /**
     * @inheritdoc
     * @return \common\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SettingQuery(get_called_class());
    }
}
