<?php

namespace backend\controllers;

use Yii;

/**
 * Class FlashTrait
 * @package backend\controllers
 */
trait FlashTrait
{
    /**
     * @param string $class
     * @param string $message
     */
    public function setFlash($class, $message)
    {
        Yii::$app->session->setFlash('alert', [
            'body'=> Yii::t('backend', $message),
            'options'=>['class'=>$class]
        ]);
    }

    public function setFlashSuccess()
    {
        $this->setFlash('alert-success', 'Data was successfully saved');
    }

    public function setFlashError()
    {
        $this->setFlash('alert-danger', 'Error occurred');
    }

    public function setFlashDeleted()
    {
        $this->setFlash('alert-success', 'Data was successfully deleted');
    }
}