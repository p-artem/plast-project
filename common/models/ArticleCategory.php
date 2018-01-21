<?php

namespace common\models;

use common\models\query\ArticleCategoryQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property integer $status
 * @property integer $sorting
 * @property string $text
 * @property string $metatitle
 * @property string $metakeys
 * @property string $metadesc
 *
 * @property Article[] $articles
 * @property ArticleCategory $parent
 */
class ArticleCategory extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const SCENARIO_NO_VALIDATE = 'no_validate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * @return ArticleCategoryQuery
     */
    public static function find()
    {
        return new ArticleCategoryQuery(get_called_class());
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
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 1024],
            [['status','sorting'], 'integer'],
            [['text', 'metatitle', 'metakeys', 'metadesc'], 'filter', 'filter' => 'trim'],
            [['text', 'metatitle', 'metakeys', 'metadesc'], 'string'],
            ['parent_id', 'exist', 'targetClass' => ArticleCategory::className(), 'targetAttribute' => 'id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'slug' => Yii::t('backend', 'Url'),
            'name' => Yii::t('backend', 'Title'),
            'text' => Yii::t('backend', 'Text'),
            'metatitle' => Yii::t('backend', 'Metatitle'),
            'metakeys' => Yii::t('backend', 'Metakeys'),
            'metadesc' => Yii::t('backend', 'Metadesc'),
            'parent_id' => Yii::t('backend', 'Parent Category'),
            'sorting' => Yii::t('backend', 'Sorting'),
            'status' => Yii::t('backend', 'Status')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @param bool $last
     * @return array
     */
    public function breadcrumbs($last = true)
    {
        return array_reverse($this->createBreadcrumbs($last));
    }

    /**`
     * @param bool $last
     * @return array
     */
    public function createBreadcrumbs($last = true)
    {
        $breadcrumbs = [];

        if ($last) {
            $breadcrumbs[] = $this->name;
        } else {
            $breadcrumbs[] = [
                'url' => Url::to([
                    '/article/index',
                    'controller'=> Yii::$app->request->get('controller'),
                    'rubric' => $this->slug != Yii::$app->request->get('controller') ? $this->slug : null
                ], true),
                'label' => $this->name,
            ];
        }
        if ($this->parent){
            $breadcrumbs = array_merge($breadcrumbs, $this->parent->createBreadcrumbs(false));
        } else {
            $breadcrumbs[] = [
                'url' => Url::to(['/article/index', 'controller'=> Yii::$app->request->get('controller')], true),
                'label' => Yii::t('site', 'News'),
            ];
        }

        return $breadcrumbs;
    }
}