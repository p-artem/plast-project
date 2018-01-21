<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArticleCategory;
use yii\db\Query;

/**
 * ArticleCategorySearch represents the model behind the search form about `common\models\ArticleCategory`.
 */
class ArticleCategorySearch extends ArticleCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['slug', 'name'], 'safe'],
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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->detachBehavior('slug');

        $query = ArticleCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%article_category}}.id' => $this->id,
            '{{%article_category}}.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', '{{%article_category}}.slug', $this->slug])
            ->andFilterWhere(['like', '{{%article_category}}.name', $this->name]);

        return $dataProvider;
    }
}
