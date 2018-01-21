<?php

namespace common\models\query;

use common\models\Article;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
/**
 * Class ArticleQuery
 * @package common\models\query
 */
class ArticleQuery extends ActiveQuery
{

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['{{%article}}.status' => Article::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function orderByPublished()
    {
        $this->orderBy('{{%article}}.published_at DESC');
        return $this;
    }

    /**
     * @return $this
     */
    public function byPopular()
    {
        $this->andWhere(['{{%article}}.popular' => Article::STATUS_PUBLISHED]);
        return $this;
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
            $this->andWhere(['between','{{%article}}.published_at', $startDate, $endDate]);
        }
        return $this;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function byCategorySlug($slug)
    {
        $this->joinWith('category category', false)
            ->andWhere(['category.slug' => $slug]);
        return $this;
    }

    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['{{%article}}.status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
        return $this;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        $this->andWhere(['{{%article}}.slug'=>$slug]);
        return $this;
    }

    public function byRubric($rubric){
        $this->joinWith('category category', false)->andWhere(['category.slug' => $rubric]);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['{{%article}}.id' => $id]);
    }

    /**
     * @return array
     */
    public function authorList()
    {
        $this->select(['author.username', 'author.id'])
            ->joinWith('author author', false)
            ->published()
            ->andWhere(['IS NOT', 'author.id', NULL])
            ->indexBy('id');

        return $this->column();
    }


    /**
     * @param int $category_id
     * @return $this
     */
    public function byCategory($category_id){
        $this->andWhere(['category_id' => $category_id]);
        return $this;
    }

    /**
     * @param $exception_id
     * @return $this
     */
    public function exceptionArticle($exception_id){
            $this->andWhere(['!=', 'id', $exception_id]);
            return $this;
    }

    /**
     * @return array
     */
    public static function getYearList(){

        $result = Article::find()
            ->select('YEAR(FROM_UNIXTIME(article.published_at))')
            ->joinWith('category category', false)
            ->orderByPublished()
            ->indexBy('YEAR(FROM_UNIXTIME(article.published_at))')
            ->column();

        return $result;
    }
}