<?php

namespace common\models;

use Yii;
use common\models\query\ArticleQuery;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;
use common\behaviors\GalleryBehavior;
use yii\helpers\Url;
/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $text
 * @property string $image
 * @property string $video
 * @property string $view
 * @property string $tags
 * @property integer $category_id
 * @property integer $status
 * @property integer $popular
 * @property integer $published_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $short
 * @property string $metatitle
 * @property string $metakeys
 * @property string $metadesc
 *
 * @property string $imageUrl
 * @property string $thumbUrl
 *
 * @property User $author
 * @property User $updater
 * @property ArticleCategory $category
 */
class Article extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @var array
     */
    public $attachments;
    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ],
            'image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'filePath' => '@images/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]].[[extension]]',
            ],
            'gallery' => [
                'class' => GalleryBehavior::className(),
                'type' => 'article',
                'extension' => 'jpg',
                'directory' => Yii::getAlias('@images/article'),
                'url' => Yii::getAlias('@imagesUrl/article'),
                'versions' => [],
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
            [['name', 'text', 'category_id'], 'required'],
            [['slug'], 'unique'],
            [['text','metatitle', 'metakeys', 'metadesc', 'tags', 'video'], 'string'],
            [['short'], 'string'],
            [['published_at'], 'default', 'value' => function () {
                return date(DATE_ISO8601);
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['category_id'], 'exist', 'targetClass' => ArticleCategory::className(), 'targetAttribute' => 'id'],
            [['status', 'popular'], 'integer'],
            [['slug'], 'string', 'max' => 1024],
            [['name'], 'string', 'max' => 512],
            [['view','tags'], 'string', 'max' => 255],
            [['published_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('backend', 'ID'),
            'slug'         => Yii::t('backend', 'Url'),
            'name'         => Yii::t('backend', 'Title'),
            'text'         => Yii::t('backend', 'Text'),
            'tags'         => Yii::t('backend', 'Tags'),
            'view'         => Yii::t('backend', 'View'),
            'image'        => Yii::t('backend', 'Image'),
            'video'        => Yii::t('backend', 'Video'),
            'thumbnail'    => Yii::t('backend', 'Thumbnail'),
            'category_id'  => Yii::t('backend', 'Category'),
            'status'       => Yii::t('backend', 'Published'),
            'popular'      => Yii::t('backend', 'Popular'),
            'published_at' => Yii::t('backend', 'Published At'),
            'created_by'   => Yii::t('backend', 'Author'),
            'updated_by'   => Yii::t('backend', 'Updater'),
            'created_at'   => Yii::t('backend', 'Created At'),
            'updated_at'   => Yii::t('backend', 'Updated At'),
            'short'        => Yii::t('backend', 'Short'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return array
     */
    public function breadcrumbs()
    {
        return array_merge($this->category->breadcrumbs(false), ['label'=>$this->name]);
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        TagDependency::invalidate(Yii::$app->frontendCache, 'article');
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
     * @param string $type
     * @return \common\behaviors\GalleryImage[]
     */
    public function getGallery($type = 'gallery')
    {
        /* @var $galleryBehavior GalleryBehavior */
        $galleryBehavior = $this->getBehavior($type);
        return $galleryBehavior->getImages();
    }

    /**
     * @return array|\common\models\Article[]
     */
    public function getPrevNext()
    {
        $result = [$this->getPrevNextData(SORT_DESC, '<')];
        if (!end($result)) {
            return $this->getPrevNextData(SORT_ASC, '>', 2);
        }

        $result[] = $this->getPrevNextData(SORT_ASC, '>');
        if (!end($result)) {
            return array_reverse($this->getPrevNextData(SORT_DESC, '<', 2));
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getPopularTags(){

        $data = self::find()->select('tags')->column();
        $popularTags = [];
        if($data){
            foreach ($data as $item){
                $item = explode(',', $item);
                if($item && is_array($item)){
                    foreach ($item as $tag){
                        $popularTags[$tag] = isset($popularTags[$tag])? $popularTags[$tag] + 1  : 1;
                    }
                }
            }
        }
        if($popularTags){
            arsort($popularTags);
            $popularTags = array_slice(array_keys($popularTags), 0, 10);
        }

        return $popularTags;
    }

    /**
     * @param int $sorting
     * @param string $condition
     * @param null|int $limit
     * @return null|\common\models\Article[]|\common\models\Article Object
     */
    protected function getPrevNextData($sorting, $condition, $limit = null)
    {
        $query = $this::find()
            ->andWhere([$condition, '{{%article}}.published_at', $this->published_at])
            ->andWhere(['{{%article}}.category_id' => $this->category_id])
            ->published()
            ->orderBy(['{{%article}}.published_at' => $sorting]);

        if ($limit) {
            return $query->limit($limit)->all();
        }
        return $query->one();
    }
}