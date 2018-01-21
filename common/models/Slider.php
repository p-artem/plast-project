<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yiidreamteam\upload\ImageUploadBehavior;
/**
 * This is the model class for table "{{%slider}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $image
 * @property string $position
 * @property string $on_main
 * @property integer $sorting
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Slider extends \yii\db\ActiveRecord
{
    const POSITION_TOP = 1;
    const POSITION_MIDDLE = 2;
    const POSITION_BOTTOM  = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider}}';
    }

    public static function getPositions(){
        return [
            self::POSITION_TOP    => Yii::t('backend', 'Position Top'),
            self::POSITION_MIDDLE => Yii::t('backend', 'Position Middle'),
            self::POSITION_BOTTOM => Yii::t('backend', 'Position Bottom'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_NO_VALIDATE] = [];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'on_main', 'status'], 'required'],
            [['text'], 'string'],
            [['position', 'on_main', 'sorting', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['sorting', 'default', 'value' => 0],
            ['image', 'safe']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'filePath' => '@images/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]].[[extension]]',
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
            'text' => Yii::t('backend', 'Text'),
            'image' => Yii::t('backend', 'Image'),
            'position' => Yii::t('backend', 'Position'),
            'on_main' => Yii::t('backend', 'On Main'),
            'sorting' => Yii::t('backend', 'Sorting'),
            'status' => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
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


    /**
     * @inheritdoc
     * @return \common\models\query\SliderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SliderQuery(get_called_class());
    }
}
