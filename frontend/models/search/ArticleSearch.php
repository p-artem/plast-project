<?php

namespace frontend\models\search;

use Yii;
use common\models\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Model
{
    /**
     * @var string
     */
    public $tag;
    /**
     * @var string
     */
    public $word;
    /**
     * @var int for per_page
     */
    public $per_page;
    /**
     * @var int for author
     */
    public  $author;
    /**
     * @var string for categorySlug
     */
    public  $categorySlug;

    /**
     * @var int for category_id
     */
    public $category_id;

    /**
     * @var int
     */
    public $year;

    const PER_PAGE_DEFAULT = 10;

    /**
     * @return array
     */
    public static function per_pages()
    {
        return [10 => 10, 20 => 20, 40 => 40];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['per_page','author', 'year'], 'integer'],
//            ['sort', 'in', 'range' => array_keys(self::sortNames())],
            ['per_page', 'in', 'range' => self::per_pages()],
            [['category_id', 'word', 'tag'], 'filter', 'filter' => 'strip_tags'],
            [['word', 'tag'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'word' => Yii::t('filter', 'Search ...'),
            'author' => Yii::t('filter', 'Author'),
            'per_page' => Yii::t('filter', 'Articles'),
            'category_id' => Yii::t('filter', 'Category'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find()->with('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'published_at' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE_DEFAULT,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if (!empty($this->per_page) && in_array($this->per_page, $this->per_pages())) {
            $dataProvider->pagination->setPageSize($this->per_page);
        }

        if(!empty($params['slug'])){
            $this->categorySlug = $params['slug'];
            $query->joinWith(['category category'])
                ->andFilterWhere([
                    'category.slug' => $this->categorySlug
                ]);
        }

        $query->andFilterWhere(['article.category_id' => $this->category_id]);
        $query->andFilterWhere(['like', 'article.tags', $this->tag]);
        $query->filterByYear($this->year);

        $word = explode(' ',$this->word);
        $query->andFilterWhere([
            'or',
            ['like', 'article.name', $word],
            ['like', 'article.text', $word]
        ]);
        
        return $dataProvider;

    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }
}