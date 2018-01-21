<?php

namespace common\models\query;

use common\models\ProductCategory;
/**
 * This is the ActiveQuery class for [[\common\models\ProductCategory]].
 *
 * @see \common\models\ProductCategory
 */
class ProductCategoryQuery extends \yii\db\ActiveQuery
{

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['{{%product_category}}.status' => ProductCategory::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug'=>$slug]);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%product_category}}.id' => $id]);
    }

    /**
     * @param int $exception_id
     * @return array
     */
    public function getList($exception_id = 0)
    {
        $this->select(['name', 'id'])
            ->orderBy('name')
            ->indexBy('id');
        if ($exception_id){
            $this->andWhere(['!=', 'id', $exception_id]);
        }
        return $this->column();
    }

    /**
     * @param int $exception_id
     * @return array
     */
    public function getSlugNameList($exception_id = 0)
    {
        $this->select(['name', 'slug'])
            ->orderBy(['sorting' => SORT_ASC])
            ->indexBy('slug');
        if ($exception_id){
            $this->andWhere(['!=', 'id', $exception_id]);
        }
        return $this->column();
    }

    /**
     * @inheritdoc
     * @return \common\models\ProductCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ProductCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
