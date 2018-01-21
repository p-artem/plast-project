<?php
namespace frontend\controllers;

use Yii;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return $this|\yii\web\Response
     */
    public function actionDownload(){
        $model = Yii::$app->appSettings->settings;
        if ($model->price){
            $file = Yii::getAlias('@base') . $model->getUploadedFileUrl('price');
            if (file_exists($file)) {
                return Yii::$app->response->sendFile($file, $model->price);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
