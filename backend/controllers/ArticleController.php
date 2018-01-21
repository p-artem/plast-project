<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use backend\models\search\ArticleSearch;
use \common\models\ArticleCategory;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use pheme\grid\actions\ToggleAction;
use backend\controllers\actions\RemoveImageAction;
use backend\controllers\actions\GalleryManagerAction;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends AbstractController
{
    use FlashTrait;
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => Article::className(),
                'attribute' => 'status',
                'scenario' => Article::SCENARIO_NO_VALIDATE,
            ],
            'toggle-menu' => [
                'class' => ToggleAction::className(),
                'modelClass' => Article::className(),
                'attribute' => 'popular',
                'scenario' => Article::SCENARIO_NO_VALIDATE,
            ],
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new Article(),
            ],
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                'types' => [
                    'article' => Article::className(),
                ]
            ],

        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update','id'=>$id ]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => ArticleCategory::find()->active()->all(),
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
