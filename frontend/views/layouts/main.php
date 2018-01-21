<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;
use frontend\widgets\SiteBreadcrumbs;

$this->beginContent('@frontend/views/layouts/_clear.php');
?>
<div id="multiple-blog-page">
    <?= $this->render('/_inc/nav_bar_header') ?>
    <header class="page-head">
        <div class="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

<!--                        <ol class="breadcrumb">-->
<!--                            <li><a href="#">blog</a></li>-->
<!--                            <li class="active">multiple blog</li>-->
<!--                        </ol> <!-- end of /.breadcrumb -->

                        <?= SiteBreadcrumbs::widget([
                            'options' => ['class' => 'breadcrumb'],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">

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