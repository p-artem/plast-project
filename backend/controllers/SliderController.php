<?php

namespace backend\controllers;

use Yii;
use common\models\Slider;
use backend\models\search\SliderSearch;
use yii\web\NotFoundHttpException;
use pheme\grid\actions\ToggleAction;
use backend\controllers\actions\RemoveImageAction;
/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends AbstractController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => Slider::className(),
                'attribute' => 'status',
                'scenario' => Slider::SCENARIO_NO_VALIDATE,
            ],
            'toggle-menu' => [
                'class' => ToggleAction::className(),
                'modelClass' => Slider::className(),
                'attribute' => 'on_main',
                'scenario' => Slider::SCENARIO_NO_VALIDATE,
            ],
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new Slider(),
            ],
        ];
    }

    /**
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']); //(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}