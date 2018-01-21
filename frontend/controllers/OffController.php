<?php

namespace frontend\controllers;

use Yii;

/**
 * Class PageController
 * @package frontend\controllers
 */
class OffController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'main_off';

    public function beforeAction($action)
    {
        if(!\Yii::$app->appSettings->settings->isSiteOff()){
            return Yii::$app->controller->redirect('/');
        }
        return parent::beforeAction($action);
    }

        public function actionIndex(){
            return $this->render('index');
        }
}