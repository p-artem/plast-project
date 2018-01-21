<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%product_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $status
 * @property integer $description
 * @property integer $sorting
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product[] $products
 */
class ProductCategory extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_category}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true,
                'ensureUnique' => true
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
            [['sorting'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 512],
            [['status', 'sorting'], 'integer'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 2048],
            [['description', 'metakeys','metatitle','metadesc'], 'filter', 'filter' => 'trim'],
            [['description', 'metakeys','metatitle','metadesc'], 'string'],
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
            'slug' => Yii::t('backend', 'Url'),
            'description' => Yii::t('backend', 'Description'),
            'sorting' => Yii::t('backend', 'Sorting'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
            'metakeys' => Yii::t('backend', 'Metakeys'),
            'metatitle' => Yii::t('backend', 'Metatitle'),
            'metadesc' => Yii::t('backend', 'Metadesc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return array
     */
    public function breadcrumbs()
    {
        return array_reverse($this->createBreadcrumbs());
    }

    /**
     * @param bool $currentElemNoUrl
     * @param ProductCategory|null $parent
     * @param Product|null $product
     * @return array
     */
    public function createBreadcrumbs($currentElemNoUrl = true, ProductCategory $parent = null, Product $product = null)
    {
        $breadcrumbs = [];

        if ($product) {
            $breadcrumbs[] = $product->name;
            $currentElemNoUrl = false;
        }

//        if ($currentElemNoUrl) {
//            $breadcrumbs[] = $this->name;
//            $breadcrumbs = array_merge($breadcrumbs, $this->createBreadcrumbs(false, $this->parent));
//        }

        if ($parent) {
            $breadcrumbs[] = [
                'url' =>Url::to(['product/index', 'controller' => 'catalog', 'categoryslug' => $this->slug], true),
                'label' => $parent->name,
            ];

            $breadcrumbs[] = [
                'url' => Url::to(['/product/index', 'controller' => 'catalog'], true),
                'label' => Yii::t('site', 'Catalog'),
            ];
        }

        return $breadcrumbs;
    }


    /**
     * @inheritdoc
     * @return \common\models\query\ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductCategoryQuery(get_called_class());
    }
}
