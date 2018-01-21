<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller as YiiController;

/**
 * Controller
 */

class Controller extends YiiController
{
    public function beforeAction($action)
    {
        if(\Yii::$app->appSettings->settings->isSiteOff()){
            $this->enableCsrfValidation = false;
           return Yii::$app->controller->redirect('/off');
        }

        // Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        return parent::beforeAction($action);
    }


}
