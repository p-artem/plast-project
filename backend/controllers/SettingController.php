<?php

namespace backend\controllers;

use Yii;
use common\models\Setting;
use yii\web\NotFoundHttpException;
use backend\controllers\actions\RemoveImageAction;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends AbstractController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new Setting(),
            ],
            'remove-price' => [
                'class' => RemoveImageAction::className(),
                'name' => 'price',
                'storagePath' => '@storage/web/source/files/price/',
                'model' => new Setting(),
            ],
        ];
    }
    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = $this->findModel(1);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlash('alert-success', 'Data was successfully saved');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return mixed|string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return $this|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownload($id){
        /** @var $model Setting */
        if($model = $this->findModel($id)){
            $file = Yii::getAlias('@base') . $model->getUploadedFileUrl('price');
            if (file_exists($file)) {
                return Yii::$app->response->sendFile($file, $model->price);
            }
        }
        $this->setFlash('alert-warning', 'File doesn\'t exist');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
