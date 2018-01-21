<?php

namespace backend\controllers;

use Yii;
use common\models\Price;
use backend\models\search\PriceSearch;
use yii\web\NotFoundHttpException;
use pheme\grid\actions\ToggleAction;
/**
 * FileController implements the CRUD actions for File model.
 */
class PriceController extends AbstractController
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => Price::className(),
                'attribute' => 'status',
                'scenario' => Price::SCENARIO_NO_VALIDATE,
            ],
        ];
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Price();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlash('alert-success', 'Data was successfully saved');
            return $this->redirect(['price/index']);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return $this|\yii\web\Response
     */
    public function actionDownload($id){
        if($model = $this->findModel($id)){
            $file = Yii::getAlias('@base') . $model->getUploadedFileUrl('file');
            if (file_exists($file)) {
                return Yii::$app->response->sendFile($file, $model->file);
            }
        }
        $this->setFlash('alert-warning', 'File doesn\'t exist');
        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Price::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
