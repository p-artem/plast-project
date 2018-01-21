<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;
use common\models\Category;
use yii\db\Expression;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Model
{
    /**
     * @var string for search
     */
    public $word;
    /**
     * @var string for sorting
     */
    public $sort;
    /**
     * @var int for per_page
     */
    public $per_page;
    /**
     * @var int brand_id
     */
    public $brand;

    /**
     *
     */
    const SORT_DEFAULT = '';
    /**
     *
     */
    const SORT_NAME_ASC = 'name';
    /**
     *
     */
    const SORT_NAME_DESC = '-name';
    /**
     *
     */
    const SORT_PRICE_ASC = 'price';
    /**
     *
     */
    const SORT_PRICE_DESC = '-price';
    const PER_PAGE_DEFAULT = 12;

    /**
     * @return array
     */
    public static function per_pages()
    {
        return [12=>12, 24=>24, 48=>48, 96=>96];
    }

    /**
     * @return array
     */
    public static function sortNames()
    {
        return [
            self::SORT_DEFAULT => Yii::t('filter', 'Default'),
            self::SORT_NAME_ASC => Yii::t('filter', 'Name (A-Z)'),
            self::SORT_NAME_DESC => Yii::t('filter', 'Name (Z-A)'),
            self::SORT_PRICE_ASC => Yii::t('filter', 'Price (low -> high)'),
            self::SORT_PRICE_DESC => Yii::t('filter', 'Price (high -> low)')
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'word' => Yii::t('filter', 'Search'),
            'sort' => Yii::t('filter', 'Sorting'),
            'brand' => Yii::t('filter', 'Brand'),
            'per_page' => Yii::t('filter', 'On Page'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand', 'per_page'], 'integer'],
            ['sort', 'in', 'range' => array_keys(self::sortNames())],
            ['per_page', 'in', 'range' => self::per_pages()],
            ['word', 'filter', 'filter' => 'strip_tags'],
            ['word', 'filter', 'filter' => 'trim'],
//            ['word', 'string', 'length' => [2]],
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
     * @param array $params
     * @param null|Category $category
     * @return ActiveDataProvider
     */
    public function search($params, Category $category = null)
    {
        $query = Product::find()->active()->distinct()
            ->with('currency', 'brand', 'productPropertiesInList', 'activeCategoryServices', 'defaultService');

        if ($category) {
            $query->joinWith('categories categories', false)
                ->andWhere(['categories.id' => $category->getChildrenIds()]);
        }

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'sorting',
//                    'price',
                    'name',
                ],
                'defaultOrder' => [
                    'sorting' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE_DEFAULT,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);
        if (!($this->load($params)
            && $this->validate()
        )) {
//            $dataProvider->query->where('1=0');
            return $dataProvider;
        }
        if (!empty($this->per_page) && in_array($this->per_page, $this->per_pages())) {
            $dataProvider->pagination->setPageSize($this->per_page);
        }

        $query->andFilterWhere(['{{%product}}.brand_id' => $this->brand]);
        if (!empty($this->word)) {
            if ($this->word{0} == "'" && $this->word{mb_strlen($this->word) - 1} == "'"){
                $words = mb_substr($this->word, 1, -1);
            } else {
                $words = array_filter(explode(' ', $this->word));
            }
            $query->andFilterWhere([
                'OR',
                ['like', '{{%product}}.name', $words],
                ['like', '{{%product}}.part_numb', $words],
//            ['like', '{{%product}}.text', $words],
//            ['like', '{{%product}}.short', $words]
            ]);
        }
        if (strpos($this->sort, self::SORT_PRICE_ASC) !== false){
            $query->joinWith('currency currency')
                ->orderBy(new Expression('product.price * currency.rate'.($this->sort == self::SORT_PRICE_DESC ? ' DESC' : '')));
        }
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