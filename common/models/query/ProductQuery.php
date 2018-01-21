<?php

namespace common\models\query;

use common\models\Product;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\Product]].
 *
 * @see \common\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['{{%product}}.status' => Product::STATUS_PUBLISHED]);
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['{{%product}}.slug' => $slug]);
    }

    public function orderLatest() {
        return $this->orderBy(['{{%product}}.created_at' => SORT_DESC]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%product}}.id' => $id]);
    }

    /**
     * @param $type
     * @return $this
     */
    public function byType($type)
    {
        return $this->andWhere(['{{%product}}.type' => $type]);
    }

    /**
     * @return $this
     */
    public function onMain()
    {
        return $this->andWhere(['{{%product}}.on_main' => Product::ON_MAIN]);
    }

    /**
     * @param $year
     * @return $this
     */
    public function filterByYear($year)
    {
        if($year){
            $startDate = mktime(0,0,0,1,1, $year);
            $endDate = mktime(0,0,0,1,1, $year + 1) - 1;
            $this->andWhere(['between','{{%product}}.created_at', $startDate, $endDate]);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return \common\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public static function getYearList(){

        $result = Product::find()
            ->select('YEAR(FROM_UNIXTIME(product.created_at))')
            ->orderBy('{{%product}}.created_at DESC')
            ->indexBy('YEAR(FROM_UNIXTIME(product.created_at))')
            ->column();

        return $result;
    }
}
