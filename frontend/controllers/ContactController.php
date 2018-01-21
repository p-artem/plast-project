<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;
use yii\web\NotFoundHttpException;
use frontend\models\SubscribeForm;

/**
 * Class ContactController
 * @package frontend\controllers
 */
class ContactController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact(){
        $request = Yii::$app->request;
        if (!$request->isAjax || !$request->isPost) {
            return $this->refresh();
        }

        $model = new ContactForm();
        $status = false;
        if ($model->load($request->post()) && $model->addContact()) {
            $status = $model->getStatus();
            $model = new ContactForm();
        }
        return $this->render('contact-us',['contactForm' => $model, 'status' => $status]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubscribe()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }
        $model = new SubscribeForm();
        $message = '';
        if ($request->isPost
            && $model->load($request->post())
            && $model->validate()
        ) {
            $message = $model->handle();
        }

        return $this->renderAjax('subscribe', ['model' => $model, 'message' => $message]);
    }
}
