<?php

namespace common\models\query;

use common\models\ArticleCategory;
use yii\db\ActiveQuery;
use Yii;
use yii\db\Query;

/**
 * Class ArticleCategoryQuery
 * @package common\models\query
 */
class ArticleCategoryQuery extends ActiveQuery
{

    /**
     * @var
     */
    protected $_data;
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => ArticleCategory::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%article_category}}.id' => $id]);
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%article_category}}.parent_id IS NULL');
        return $this;
    }

    /**
     * @param int $exception_id
     * @return array
     */
    public function getList($exception_id = 0)
    {
        $this->select(['name', 'id'])->orderBy('name')->indexBy('id');
        if ($exception_id){
            $this->andWhere(['!=', 'id', $exception_id]);
        }
        return $this->column();
    }

    /**
     * @param array $fields
     * @return array
     */
    public function getAllAsTree($fields = ['name', 'id', 'slug'])
    {
        $this->select(array_merge($fields,['parent_id']))
            ->addOrderBy(['sorting' => SORT_ASC, 'id' => SORT_ASC])
            ->indexBy('id');

        $this->_data = $this->asArray()->all();
        $result = $this->createTree();
        return $result;
    }

    /**
     * @return array
     */
    protected function createTree()
    {
        $tree = [];
        foreach ($this->_data as $key => &$item) {
            if (!$item['parent_id']){
                $tree[$item['id']] = &$item;
            } elseif(!empty($this->_data[$item['parent_id']])) {
                $this->_data[$item['parent_id']]['items'][$item['id']] = &$item;
            }
        }
        return $tree;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }

}