<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\Page;
use common\models\ProductCategory;
use yii\web\NotFoundHttpException;
use Yii;;

class ProductController extends Controller
{
    /**
     * @param string $categoryslug
     * @param string $by
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($categoryslug = '', $by = '')
    {
        $year = (int) $by;

        $model = Page::find()->active()->bySlug('catalog')->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }

        $categories = ProductCategory::find()->active()->getSlugNameList();

        $query = Product::find()->active()
            ->joinWith('category category', false)
            ->andWhere(['category.status' => ProductCategory::STATUS_ACTIVE]);
            if($categoryslug){
                $query->andWhere(['category.slug' => $categoryslug]);
            }
            $query->filterByYear($year)
            ->orderBy('{{%product}}.sorting ASC')
            ->with(['category']);

            $products = $query->all();

        return $this->render('index', [
            'model'        => $model,
            'products'     => $products,
            'categories'   => $categories,
            'categoryslug' => $categoryslug,
            'by'           => $by,
        ]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Product::find()->bySlug($slug)->with(['category'])->one();
        $page = Page::find()->active()->one();

        if (!$model || !$page) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }

        return $this->render('view', [
            'model'    => $model,
            'page'     => $page,
        ]);
    }
}