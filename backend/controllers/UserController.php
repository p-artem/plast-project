<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserForm;
use backend\models\search\UserSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\UserPhone;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AbstractController
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $model = new UserForm();
        $model->setScenario('create');
        if ($model->load($post)) {
            $model->phone_input = $model->phone;
            if ($model->save($post)){
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
        ]);
    }

    /**
     * Updates an existing User model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $model = new UserForm();
        $model->setModel($this->findModel($id));
        if ($model->load($post)) {
            $model->phone_input = $model->phone;
            if ($model->save($post)){
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->authManager->revokeAll($id);
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
