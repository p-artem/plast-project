<?php

namespace backend\controllers;

use backend\controllers\actions\RemoveImageAction;
use common\models\ProductCategory;
use pheme\grid\actions\ToggleAction;
use Yii;
use common\models\Product;
use backend\models\search\ProductSearch;
use yii\web\NotFoundHttpException;
use backend\controllers\actions\GalleryManagerAction;

/**
 * Class ProjectController
 * @package backend\controllers
 */
class ProductController extends AbstractController
{
    use FlashTrait;

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                'types' => [
                    'product' => Product::className()
                ]
            ],
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => Product::className(),
                'attribute' => 'status',
                'scenario' => ProductCategory::SCENARIO_NO_VALIDATE,
            ],
            'toggle-menu' => [
                'class' => ToggleAction::className(),
                'modelClass' => Product::className(),
                'attribute' => 'on_main',
                'scenario' => Product::SCENARIO_NO_VALIDATE,
            ],
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new Product(),
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlashSuccess();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => ProductCategory::find()->active()->all()
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlashSuccess();
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'categories' => ProductCategory::find()->active()->all(),
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
