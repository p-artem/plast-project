<?php

namespace backend\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
abstract class AbstractController extends Controller
{
    /**
     * @var ActiveRecord
     */
    protected $_model;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Displays a single ActiveRecord model.
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
     * Updates an existing ActiveRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlash('alert-success', 'Data was successfully saved');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing ActiveRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $model->delete();
            $this->setFlash('alert-success', 'Data was successfully deleted');
        } catch (Exception $e) {
            if ($e->errorInfo[0] == '23000' && $e->errorInfo[1] == 1451) {
                $this->setFlash('alert-error', 'There are related records');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionRemoveFile($id)
    {
        $model = $this->findModel($id);
        $this->_model = $model;
        $this->removeFile();

        return $this->redirect(['update', 'id' => $model->id]);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function uploadFile($name = 'image'){
        $model = $this->_model;
        $icon = UploadedFile::getInstance($model, $name);
        if ($icon){
            $path = Yii::getAlias('@images/') . $this->getShortClass($model) . DIRECTORY_SEPARATOR .
                $model->id;
            BaseFileHelper::createDirectory($path, 0775, true);
            $fileName = substr(md5(microtime(true) . $path), 4, 6)
                . '.' . $icon->extension;
            $oldFileName = $model->$name;
            if ($icon->saveAs($path . DIRECTORY_SEPARATOR . $fileName)){
                $model->$name = $fileName;
                if ($model->save() && $oldFileName /*&& file_exists($path . DIRECTORY_SEPARATOR . $oldFileName)*/){
                    @unlink($path . DIRECTORY_SEPARATOR . $oldFileName);
                }
            }

            return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @param bool $removeDir
     */
    protected function removeFile($name = 'image', $removeDir = false)
    {
        $model = $this->_model;
        if ($model->$name) {
            $path = Yii::getAlias('@images/') . $this->getShortClass($model) . DIRECTORY_SEPARATOR .
                $model->id;
            @unlink($path . DIRECTORY_SEPARATOR . $model->$name);
            if ($removeDir) {
                BaseFileHelper::removeDirectory($path);
            }
            $model->$name = '';
            $model->save();
        }
    }

    /**
     * @param $obj
     * @return string
     */
    protected function getShortClass($obj)
    {
        $className = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $className, $matches)) {
            $className = $matches[1];
        }

        return strtolower($className);
    }

    /**
     * @param $class
     * @param $message
     */
    protected function setFlash($class, $message)
    {
        Yii::$app->session->setFlash('alert', [
            'body'=> Yii::t('backend', $message),
            'options'=>['class'=>$class]
        ]);
    }

    /**
     * @param $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    abstract protected function findModel($id);
}