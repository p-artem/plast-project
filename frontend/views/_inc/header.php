<?php
use yii\helpers\Url;
?>

<div class="header-overlay"></div>
<div class="header-wrapper-inner">
    <div class="container">
        <div class="welcome-speech">
            <h1><?= Yii::t('site', 'Welcome to {siteName}', ['siteName' => Yii::$app->appSettings->settings->name]) ?></h1>
            <p><?= Yii::t('site', 'Everything you need to have in order to build a stunning website') ?></p>
            <a href="<?= Url::to(['/page/view', 'slug' => 'catalog'])?>" class="btn btn-white">
                <?= Yii::t('site', 'Our Products') ?>
            </a>
        </div>
    </div>
</div>
