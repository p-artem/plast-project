<?php

namespace frontend\models\search;

use Yii;
use common\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    public $word;
    /**
     * @var int for per_page
     */
    public $per_page;
    /**
     * @var int for author
     */
    public  $status;

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
            [['per_page','status'], 'integer'],
//            ['sort', 'in', 'range' => array_keys(self::sortNames())],
            ['per_page', 'in', 'range' => self::per_pages()],
            [['word'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'word' => Yii::t('filter', 'Search by orders'),
            'status' => Yii::t('filter', 'Status order'),
            'per_page' => Yii::t('filter', 'Orders per page'),
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
        $query = Order::find()->joinWith('user user', false)
            ->andWhere(['user.id' => Yii::$app->user->id]);//->with('articleAttachments');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'defaultPageSize' => self::PER_PAGE_DEFAULT,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ]
        ]);

//        if(!empty($params['categoryslug'])){
//            $this->categorySlug = $params['categoryslug'];
//            $query->joinWith(['category category'])
//                ->andFilterWhere([
//                    'category.slug' => $this->categorySlug
//                ]);
//        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        if (!empty($this->per_page) && in_array($this->per_page, $this->per_pages())) {
            $dataProvider->pagination->setPageSize($this->per_page);
        }

//        if(!empty($this->author)){
//            $query->joinWith(['author author'])
//                ->andFilterWhere([
//                    'author.id' => $this->author
//                ]);
//        }
        $query->andFilterWhere([
            '{{%order}}.status' => $this->status,
        ]);

        $query->andFilterWhere([
            'or',
            ['like', '{{%order}}.id', $this->word],
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