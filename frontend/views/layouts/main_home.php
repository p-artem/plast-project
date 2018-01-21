<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

$this->beginContent('@frontend/views/layouts/_clear.php');
$image = Yii::$app->appSettings->settings->getImageUrl('main_image') ?: '../img/slider1.jpg';

$headerImgStyles = 'background: url('. $image .') no-repeat center center;
    background-attachment: fixed;
    background-size: cover;
    display: table;
    height: calc(80vh - 72px);
    width: 100%;
    position: relative;
    z-index: 1;
    overflow-x: hidden;'
?>
<div id="home-page">
    <?= $this->render('/_inc/nav_bar_header') ?>
    <header id="header" class="header-wrapper home-parallax home-fade" style="<?= $headerImgStyles ?>">
        <?= $this->render('/_inc/header') ?>
    </header>

    <div class="main-content">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if(Yii::$app->session->hasFlash('alert')):?>
            <?= \yii\bootstrap\Alert::widget([
                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ])?>
        <?php endif; ?>

        <?= $content ?>

    </div>

    <footer class="main-foot">
        <?= $this->render('/_inc/footer') ?>
        <?= $this->render('/_inc/modal-set') ?>
        <div class="btn-top">&nbsp;</div>
    </footer>

    <div class="loaded"></div>
</div>

<?php $this->endContent() ?>