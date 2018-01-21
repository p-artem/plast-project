<?php

namespace backend\controllers;

use backend\controllers\actions\RemoveImageAction;
use common\models\PageMenu;
use League\Flysystem\Exception;
use pheme\grid\actions\ToggleAction;
use Yii;
use common\models\Page;
use backend\models\search\PageSearch;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use backend\controllers\actions\GalleryManagerAction;

/**
 * Class PageController
 * @package backend\controllers
 */
class PageController extends AbstractController
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
                'modelClass' => Page::className(),
                'attribute' => 'status',
                'scenario' => Page::SCENARIO_NO_VALIDATE,
            ],
            'remove-image' => [
                'class' => RemoveImageAction::className(),
                'model' => new Page(),
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlashSuccess();
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
