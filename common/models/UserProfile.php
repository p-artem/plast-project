<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property integer $locale
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $picture
 * @property string $birthday
 * @property string $city
 * @property string $avatar
 * @property integer $gender
 *
 * @property string $imageUrl
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * @var
     */
    protected $_avatar = '@imagesUrl/userProfile/anonymous.jpg';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'avatar' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'avatar',
                'filePath' => '@images/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]].[[extension]]',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender'], 'integer'],
            [['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'middlename', 'lastname', 'position'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            ['avatar', 'safe'],

            ['birthday', 'date', 'format' => 'Y-m-d'],
            ['city', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('user', 'User ID'),
            'firstname' => Yii::t('user', 'Firstname'),
            'middlename' => Yii::t('user', 'Middlename'),
            'lastname' => Yii::t('user', 'Lastname'),
            'locale' => Yii::t('user', 'Locale'),
            'picture' => Yii::t('user', 'Picture'),
            'gender' => Yii::t('user', 'Gender'),
            'birthday' => Yii::t('user', 'Birthday'),
            'city' => Yii::t('user', 'City'),
            'position' => Yii::t('user', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getFullName()
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }
        return null;
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getImageUrl($default = null)
    {
        /* @var $imageUploadBehavior ImageUploadBehavior */
        $imageUploadBehavior = $this->getBehavior('avatar');
        return ($imageUploadBehavior->getImageFileUrl('avatar')
            ?: $default)
            ?: $imageUploadBehavior->getImageFileUrl('avatar', Yii::getAlias($this->_avatar));
    }
}