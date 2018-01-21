<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;
use yii\db\ActiveQuery;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_by', 'updated_by', 'popular', 'status', 'published_at', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'name', 'text'], 'safe'],
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
        $this->detachBehavior('slug');

        $query = Article::find()
            ->with(['category', 'author', 'category'], false);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%article}}.id' => $this->id,
            '{{%article}}.created_by' => $this->created_by,
            '{{%article}}.category_id' => $this->category_id,
            '{{%article}}.updated_by' => $this->updated_by,
            '{{%article}}.status' => $this->status,
            '{{%article}}.popular' => $this->popular,
            '{{%article}}.published_at' => $this->published_at,
            '{{%article}}.created_at' => $this->created_at,
            '{{%article}}.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', '{{%article}}.slug', $this->slug])
            ->andFilterWhere(['like', '{{%article}}.name', $this->name])
            ->andFilterWhere(['like', '{{%article}}.text', $this->text]);

        return $dataProvider;
    }
}
