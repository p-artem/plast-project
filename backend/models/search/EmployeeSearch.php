<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employee;
use yii\db\ActiveQuery;

/**
 * EmployeeSearch represents the model behind the search form about `common\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * @var string
     */
    public $fullName;
    /**
     * @var string
     */
    public $maskPhone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sorting', 'status'], 'integer'],
            [['email', 'phone', 'name', 'surname', 'patronymic', 'position', 'fullName', 'maskPhone'], 'safe']
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

        $query = Employee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->maskPhone]);
        $query->andFilterWhere(['like', 'sorting', $this->sorting]);
        $query->andFilterWhere(['like', 'position', $this->position]);
        $query->andFilterWhere(['like', 'name', $this->fullName]);
        $query->orFilterWhere(['like',  'surname', $this->fullName]);
        $query->orFilterWhere(['like',  'patronymic', $this->fullName]);

        return $dataProvider;
    }
}
