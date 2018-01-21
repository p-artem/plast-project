<?php

namespace common\models;

use Yii;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "{{%social}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $image
 * @property integer $sorting
 * @property integer $status
 */
class Social extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social}}';
    }

    public function behaviors()
    {
        return[
            'image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'filePath' => '@images/[[model]]/[[pk]]/image.[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]]/image.[[extension]]',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sorting'], 'default', 'value' => 0],
            [['name', 'link'], 'required'],
            [['sorting', 'status'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255],
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
            'link' => Yii::t('backend', 'Link'),
            'image' => Yii::t('backend', 'Image'),
            'sorting' => Yii::t('backend', 'Sorting'),
            'status' => Yii::t('backend', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\SocialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SocialQuery(get_called_class());
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getImageUrl($name = 'image')
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
}