<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yiidreamteam\upload\FileUploadBehavior;
/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property string $file
 * @property integer $sorting
 * @property integer $status
 * @property integer $created_at
 */
class Price extends \yii\db\ActiveRecord
{
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%price}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' =>  TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                    self::EVENT_BEFORE_UPDATE => [],
                ],
            ],
            'file' => [
                'class' => FileUploadBehavior::className(),
                'attribute' => 'file',
                'filePath' => '@storage/web/source/files/price/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@storageUrl/web/source/files/price/[[model]]/[[pk]].[[extension]]',
            ],

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
            [['file', 'sorting', 'status'], 'required'],
            [['sorting', 'status'], 'integer'],
            ['sorting', 'default', 'value' => 0],
            [
                ['file'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => ['xls', 'xlsx'],//'xml, yml, csv',
                'checkExtensionByMimeType' => false
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
            'file' => Yii::t('backend', 'File'),
            'sorting' => Yii::t('backend', 'Sorting'),
            'status' => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FileQuery(get_called_class());
    }
}
