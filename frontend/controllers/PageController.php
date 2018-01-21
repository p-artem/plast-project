<?php

namespace frontend\controllers;

use Yii;
use common\models\Page;
use common\models\Product;
use yii\web\NotFoundHttpException;
use frontend\models\ContactForm;

/**
 * Class PageController
 * @package frontend\controllers
 */
class PageController extends Controller
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
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error')
            $this->layout = 'main_error.php';

        return parent::beforeAction($action);
    }
    /**
     * @return string
     */
    public function actionHome()
    {
        $model = Page::find()->active()->bySlug('home')->one();
        if (!$model) {
            $model = new Page();
        }

        $products  = Product::find()
            ->with(['category'])
            ->onMain()
            ->groupBy('id')
            ->orderBy(['sorting' => SORT_ASC])
            ->limit(4)
            ->all();

        return $this->render('home',
            compact(
                'model',
                'products'
            )
        );
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Page::find()->active()->bySlug($slug)->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }

        return $this->render('view', ['model' => $model]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionContacts()
    {
        $model = Page::find()->active()->bySlug('contacts')->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('site', 'Page not found'));
        }

        $contactForm = new ContactForm();

        return $this->render('contacts', [
            'model' => $model,
            'contactForm' => $contactForm
        ]);
    }

    /**
     * @return string
     */
    public function actionHtmlTemplate()
    {
        $model = new Page();
        return $this->render('_html-template', ['model'=>$model]);
    }

    /**
     * Add for display basic markup
     * @return string
     */
    public function actionInnerPage()
    {
        $model = Page::find()->active()->bySlug('designers')->one();
        return $this->render('inner-page', ['model'=>$model]);
    }

    public function actionOff(){

        dd(11);
    }
}