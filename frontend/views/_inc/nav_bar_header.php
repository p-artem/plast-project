<?php

use common\models\Page;
use common\models\PageMenu;
use frontend\widgets\TopMenuWidget;
use yii\helpers\Url;
?>
<style>
    #mainNavigation {
        text-align: center;
        width: 100%;
    }
    span.span-fixed {
        position: fixed;
        top: 200px;
        left: 20px;
    }
    .nofixed,
    .hidden-menu {
        position: absolute;
        z-index: 300;
    }
    .hidden-menu {
        transform: translateY(-370px);
    }
    .fixed-menu {
        position: fixed;
        transform: translateY(0);
        transition: transform 0.9s;
        z-index: 300;
        border-bottom: 2px solid #AEAEAE;
    }
</style>
<!-- site-navigation start -->
<nav id="mainNavigation" class="navbar navbar-dafault main-navigation nofixed" role="navigation">
    <div class="container">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="navbar-brand">
                <span class="sr-only"><?= Yii::$app->appSettings->settings->name ?></span>
                <a href="<?= Url::to('/') ?>">
                    <img src="<?= Yii::$app->appSettings->settings->getImageUrl() ?>" class="img-responsive center-block" alt="logo">
                </a>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="main-nav-collapse">


            <?= TopMenuWidget::widget([
                'items'                 => Page::find()->byMenuId(PageMenu::MENU_TOP)->getAllAsTree(),
                'route'                 => '/page/view',
                'maxDept'               => 1,
                'labelTemplate'         => '<div><span>{label}</span></div>',
                'submenuTemplate'       => "<ul class='dropdown-menu'>\n{items}\n</ul>\n",
                'parentLinkTemplate'    => "<div class='dropdown-toggle' data-toggle=\"dropdown\">\n<span>{label}</span>\n</div>\n",
                'subLinkTemplate'       => "<a href='{url}'>\n<span>{label}</span>\n</a>\n",
                'subLabelTemplate'      => "<span>\n<span>{label}</span>\n</span>\n",
                'params'                => isset($this->params['activeMenu']) ? $this->params['activeMenu'] : null,
                'subActive'             => isset($this->params['subActive']) ? $this->params['subActive'] : null,
            ]) ?>
        </div>
    </div>
</nav>

<span class="span-fixed"></span>
<div style="padding-bottom: 72px"></div>