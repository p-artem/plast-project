<?php
/* @var $this \yii\web\View */
/* @var $projects \common\models\Product[] */
/* @var $model \common\models\Page */
/* @var $points array */

use yii\helpers\Url;
use frontend\widgets\ProjectOnMainWidget;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use common\models\Product;
use frontend\widgets\SliderWidget;
use common\models\Slider;

$this->context->layout = 'main_home';
$this->params['activeMenu'] = ['route'=>'page/home'];

$this->title = $model->metatitle ?: Yii::$app->appSettings->settings->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: Yii::$app->name]);
?>
<section class="intro bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="/img/intro.jpg" class="img-responsive center-block" alt="intro">
            </div>

            <div class="col-md-7">
                <div class="intro-description">
                    <?= Yii::$app->appSettings->settings->text ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white feature">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="feature-content text-center">
                    <div class="feature-icon-box">
                        <div class="feature-icon center-block">
                            <i class="fa fa-truck"></i>
                        </div>
                    </div>
                    <div class="feature-info">
                        <h3 class="feature-heading"><?= Yii::t('site', 'Delivery in the city') ?></h3>
                        <p class="feature-description">
                            <?= Yii::t('site', 'We will deliver the goods at a convenient place and time for you') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-content text-center">
                    <div class="feature-icon-box">
                        <div class="feature-icon center-block">
                            <i class="fa fa-user-circle"></i>
                        </div>
                    </div>
                    <div class="feature-info">
                        <h3 class="feature-heading"><?= Yii::t('site', 'Availability of managers 24/7') ?></h3>
                        <p class="feature-description">
                            <?= Yii::t('site', 'Our managers will always be able to advise you and answer your questions') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-content text-center">
                    <div class="feature-icon-box">
                        <div class="feature-icon center-block">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                    </div>
                    <div class="feature-info">
                        <h3 class="feature-heading"><?= Yii::t('site', 'Positive communication') ?></h3>
                        <p class="feature-description">
                            <?= Yii::t('site', 'We will certainly help and advise you in selecting the product') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-content text-center">
                    <div class="feature-icon-box">
                        <div class="feature-icon center-block">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                    </div>
                    <div class="feature-info">
                        <h3 class="feature-heading"><?= Yii::t('site', 'Transparent pricing') ?></h3>
                        <p class="feature-description">
                            <?= Yii::t('site', 'The prices for our products reflect the interests of all market participants') ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="bg-light-gray">
    <div class="container">

        <div class="headline text-center">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="section-title"><?= Yii::t('site', 'Our products')?></h2>
<!--                    <p class="section-sub-title">-->
<!--                        --><?//= Yii::t('site', 'absolutely stunning design &amp; functionality')?>
<!--                    </p>-->
                </div>
            </div>
        </div>

        <div class="portfolio-item-list">
            <div class="row">
                <?php foreach (Product::find()->active()->onMain()->all() as $product): ?>
                    <?= $this->render('_home_product', ['model' => $product]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<section class="twit-feed">
    <div class="twit-feed-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div id="twit" class="owl-carousel owl theme">
                      <?= SliderWidget::widget([
                          'itemTemplate' => '/page/_slider-middle-item',
                          'items' => Slider::find()->active()->byPosition(Slider::POSITION_MIDDLE)->all()
                      ])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-light-gray">
    <div class="container">

        <div class="headline text-center">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3 class="section-title"><?= Yii::t('site', 'Technological achievements')?></h3>
                    <p class="section-sub-title">
                        <?= Yii::t('site', 'We pay great attention to the introduction of innovations') ?>
                    </p>
                </div>
            </div>
        </div>
        <div id="client-speech" class="owl-carousel owl-theme">
            <?= SliderWidget::widget([
                'itemTemplate' => '/page/_slider-bottom-item',
                'blocks' => 2,
                'partsLayout' => '<div class="item"><div class="row">{items}</div></div>',
                'items' => Slider::find()->active()->byPosition(Slider::POSITION_BOTTOM)->all()
            ])?>
        </div>
    </div>
</section>
