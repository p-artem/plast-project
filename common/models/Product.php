<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yiidreamteam\upload\ImageUploadBehavior;
use common\behaviors\GalleryBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $slug
 * @property string $image
 * @property string $image_slider
 * @property integer $status
 * @property integer $sorting
 * @property integer $type
 * @property integer $on_main
 * @property integer $created_at
 * @property integer $updated_at
 * @property string name
 * @property string text
 * @property string $short
 * @property string location
 * @property string function
 * @property string size
 * @property string state
 * @property string architects
 * @property string clients
 * @property string collaboration
 * @property string $metatitle
 * @property string $metakeys
 * @property string $metadesc
 *
 * @property ProductCategory $category
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    const ON_MAIN = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true
            ],
            'image' => [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'image',
                'thumbs' => [
                    'thumb' => ['width' => 370, 'height' => 261],
                ],
                'filePath' => '@images/[[model]]/[[pk]].[[extension]]',
                'fileUrl' => '@imagesUrl/[[model]]/[[pk]].[[extension]]',
                'thumbPath' => '@images/[[model]]/[[pk]]_thumb.[[extension]]',
                'thumbUrl' => '@imagesUrl/[[model]]/[[pk]]_thumb.[[extension]]',
            ],
            'gallery' => [
                'class' => GalleryBehavior::className(),
                'type' => 'product',
                'extension' => 'jpg',
                'directory' => Yii::getAlias('@images/product'),
                'url' => Yii::getAlias('@imagesUrl/product'),
                'versions' => []
            ]
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
            [['sorting', 'on_main'], 'default', 'value' => 0],
            [['category_id', 'name'], 'required'],
            [['category_id', 'status', 'sorting'], 'integer'],
            [['slug'], 'unique'],
            [['short'], 'string'],
            [['slug'], 'string', 'max' => 2048],
            [['name'], 'string', 'max' => 512],
            [
                ['text', 'location','function','size','state', 'architects',
                'clients', 'collaboration', 'metakeys','metatitle','metadesc'],
                'string'
            ],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['created_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('backend', 'ID'),
            'category_id'   => Yii::t('backend', 'Category'),
            'slug'          => Yii::t('backend', 'Url'),
            'image'         => Yii::t('backend', 'Image'),
            'image_slider'  => Yii::t('backend', 'Image Slider'),
            'name'          => Yii::t('backend', 'Name'),
            'text'          => Yii::t('backend', 'Text'),
            'location'      => Yii::t('backend', 'Location'),
            'function'      => Yii::t('backend', 'Function'),
            'size'          => Yii::t('backend', 'Size'),
            'state'         => Yii::t('backend', 'State'),
            'architects'    => Yii::t('backend', 'Architects'),
            'clients'       => Yii::t('backend', 'Clients'),
            'collaboration' => Yii::t('backend', 'Collaboration'),
            'status'        => Yii::t('backend', 'Status'),
            'type'          => Yii::t('backend', 'Type'),
            'sorting'       => Yii::t('backend', 'Sorting'),
            'created_at'    => Yii::t('backend', 'Created At'),
            'updated_at'    => Yii::t('backend', 'Updated At'),
            'on_main'       => Yii::t('backend', 'On main'),
            'short'         => Yii::t('backend', 'Short'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getImageUrl($name = 'image')
    {
        /* @var $imageUploadBehavior ImageUploadBehavior */
        $imageUploadBehavior = $this->getBehavior($name);
        if(!file_exists($imageUploadBehavior->getUploadedFilePath($name))) return '/img/no_image.png';

        if ($imageUrl = $imageUploadBehavior->getImageFileUrl($name)){
            if (($timestamp = @filemtime($imageUploadBehavior->getUploadedFilePath($name))) > 0) {
                $imageUrl .= "?_=$timestamp";
            }
        }
        return $imageUrl;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getThumbUrl($name = 'image')
    {
        /* @var $imageUploadBehavior ImageUploadBehavior */
        $imageUploadBehavior = $this->getBehavior($name);
        if(!file_exists($imageUploadBehavior->getThumbFilePath($name))) return '/img/no_image_370.png';

        if ($imageUrl = $imageUploadBehavior->getThumbFileUrl($name)){
            if (($timestamp = @filemtime($imageUploadBehavior->getUploadedFilePath($name))) > 0) {
                $imageUrl .= "?_=$timestamp";
            }
        }
        return $imageUrl;
    }

    /**
     * @param string $type
     * @return \zxbodya\yii2\galleryManager\GalleryImage[]
     */
    public function getGallery($type = 'gallery')
    {
        /* @var $galleryBehavior GalleryBehavior */
        $galleryBehavior = $this->getBehavior($type);
        return $galleryBehavior->getImages();
    }

    /**
     * @return array
     */
    public function breadcrumbs()
    {
        /** @var ProductCategory $category */
        $category = $this->category;

        if ($category)
            return array_reverse($category->createBreadcrumbs(false, $category, $this));
        else
            return [$this->name];
    }

    /**
     * @return array|\common\models\Product[]
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
     * @param int $sorting
     * @param string $condition
     * @param null|int $limit
     * @return null|\common\models\Product[]|\common\models\Product Object
     */
    protected function getPrevNextData($sorting, $condition, $limit = null)
    {
        $query = $this::find()
            ->andWhere([$condition, '{{%product}}.created_at', $this->created_at])
            ->andWhere(['{{%product}}.type' => $this->type])
            ->orderBy(['{{%product}}.created_at' => $sorting]);

        if ($limit) {
            return $query->limit($limit)->all();
        }
        return $query->one();
    }

}
