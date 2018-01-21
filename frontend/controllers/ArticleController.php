<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Page;
use yii\web\NotFoundHttpException;
use Yii;
use frontend\models\search\ArticleSearch;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{
    /**
     * @param string $year
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($year = '')
    {
        $model = Page::find()->active()->andWhere(['slug' => 'news'])->one();

        if(!$model){
            throw new NotFoundHttpException();
        }

        $searchModel = new ArticleSearch();
        $searchRequest = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($searchRequest, $model);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
            'year'  => $year,
            'itemType' => 'news',
        ]);
    }

    /**
     * @param $rubric
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($rubric, $slug)
    {
        $model = Article::find()->published()->bySlug($slug)->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }

        return $this->render('view', ['model'=>$model]);
    }
}