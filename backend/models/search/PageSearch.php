<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Page;
use common\models\PageMenu;
use yii\db\ActiveQuery;

/**
 * PageSearch represents the model behind the search form about `common\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'sorting', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug', 'h1', 'text', 'metatitle', 'metakeys', 'metadesc'], 'safe'],
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
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->detachBehavior('slug');

        $query = Page::find()
            ->select([Page::tableName(). '.*', 'IF(pageMenus.menu_id='.  PageMenu::MENU_TOP .',1,0) inTop'])
            ->with(['parent'])
            ->joinWith(['pageMenus pageMenus'], false)
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%page}}.id' => $this->id,
            '{{%page}}.parent_id' => $this->parent_id,
            '{{%page}}.sorting' => $this->sorting,
            '{{%page}}.status' => $this->status,
            '{{%page}}.created_at' => $this->created_at,
            '{{%page}}.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', '{{%page}}.name', $this->name])
            ->andFilterWhere(['like', '{{%page}}.slug', $this->slug]);

        return $dataProvider;
    }
}
