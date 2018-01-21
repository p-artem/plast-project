<?php
/* @var $this \yii\web\View */


use common\models\Article;
use frontend\models\SubscribeForm;
use frontend\widgets\TopMenuWidget;
use common\models\Page;
use common\models\PageMenu;
use common\models\Price;

$model = new SubscribeForm();
$price = Price::find()->active()->orderBy(['sorting' => SORT_DESC])->one();

?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12 footer-widget">
            <h4><?= Yii::t('site', 'Recent News')?></h4>
            <?php foreach (Article::find()->active()->orderByPublished()->limit(2)->all() as $article): ?>
                <?= $this->render('_footer_recent_post', ['model' => $article]) ?>
            <?php endforeach; ?>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 footer-widget">
            <?= $this->render('/contact/subscribe', ['model' => $model, 'message' => ''])?>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 footer-widget">
            <h4><?= Yii::$app->appSettings->settings->name ?></h4>
            <p>
                <?= Yii::$app->appSettings->settings->short ?>
            </p>
            <div class="footer-address">
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <p>
                            <?= Yii::$app->appSettings->settings->main_phone ?>  <br>
                            <?= Yii::$app->appSettings->settings->main_email ?>
                        </p>
                    </div>
                    <div class="col-md-6 col-xs-6">
                    </div>
                </div>
            </div>
            <div>

            </div>

<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <ul class="footer-share-button">-->
<!--                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>-->
<!--                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>-->
<!--                    </ul> <!-- /.footer-share-button -->
<!--                </div>-->
<!--            </div>-->
        </div>

    </div>
</div>

<nav class="hidden-xs hidden-sm navbar footer-nav" role="navigation">
    <div class="container">


        <div class="navbar-brand">
            <span class="sr-only">&copy;&nbsp;<?= Yii::$app->name ?> 2016–<?= date('Y') ?></span>
            <a href="/">
                &copy;&nbsp;<?= Yii::$app->name ?> 2016–<?= date('Y') ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="main-nav-collapse">
            <?= TopMenuWidget::widget([
                'items'   => Page::find()->byMenuId(PageMenu::MENU_TOP)->getAllAsTree(),
                'route'   => '/page/view',
                'maxDept' => 1,
                'labelTemplate'=> '<div class="footer-nav"><span>{label}</span></div>',
                'params'  => isset($this->params['activeMenu']) ? $this->params['activeMenu'] : null,
                'options' => ['class' => 'nav navbar-nav navbar-right']
            ]) ?>
        </div>

    </div>
</nav>
