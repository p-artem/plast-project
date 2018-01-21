<?php

namespace common\models\query;

use common\models\Page;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends \yii\db\ActiveQuery
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
        return $this->andWhere(['{{%page}}.status' => Page::STATUS_PUBLISHED]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%page}}.id' => $id]);
    }


    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['{{%page}}.slug' => $slug]);
    }

    /**
     * @param int $exception_id
     * @return array
     */
    public function getList($exception_id = 0)
    {
        $list = $this->select(['{{%page}}.name', '{{%page}}.id'])->indexBy('id');

        if ($exception_id){
            $list->andWhere(['!=', 'id', $exception_id]);
        }
        return $list->column();
    }

    /**
     * @return array
     */
    public function getParentsList()
    {
        // Выбираем только те категории, у которых есть дочерние категории
        $parents = $this->select(['parent.name name', 'parent.id id'])
            ->joinWith('parent parent', false)
            ->andWhere(['IS NOT', 'parent.id', NULL])
            ->orderBy('parent.name')
            ->indexBy('id')
            ->asArray()
            ->column();
        return $parents;
    }

    /**
     * @return $this
     */
    public function onlyMain()
    {
        return $this->andWhere('{{%page}}.parent_id is NULL');
    }

    /**
     * @param $menu_id
     * @return $this
     */
    public function byMenuId($menu_id)
    {
        return $this->active()
            ->joinWith('pageMenus pageMenus', false)
            ->andWhere(['pageMenus.menu_id' => $menu_id]);
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    public function getAllAsTree($fields = ['name', 'id', 'slug', 'brief'])
    {
        $this->select(array_merge($fields,['parent_id']))
            ->addOrderBy(['sorting' => SORT_ASC, 'id' => SORT_ASC])
            ->indexBy('id');

        $this->_data = $this->asArray()->all();

        $result = $this->createTree();
        return $result;
    }

    /**
     * @inheritdoc
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
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
}
