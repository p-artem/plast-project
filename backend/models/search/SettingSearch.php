<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Setting;

/**
 * SettingSearch represents the model behind the search form about `common\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_site'], 'integer'],
            [['name', 'short', 'text', 'logo', 'main_image', 'main_phone', 'phone', 'email', 'main_email', 'address', 'coordinate_x', 'coordinate_y'], 'safe'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Setting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status_site' => $this->status_site,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short', $this->short])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'main_image', $this->main_image])
            ->andFilterWhere(['like', 'main_phone', $this->main_phone])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'main_email', $this->main_email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'coordinate_x', $this->coordinate_x])
            ->andFilterWhere(['like', 'coordinate_y', $this->coordinate_y]);

        return $dataProvider;
    }
}
