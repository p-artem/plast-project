<?php
/**
 * @var $model \common\models\Article
 */

use yii\helpers\Url;
?>
<div class="row footer-news">
    <div class="col-md-4 col-sm-4 col-xs-6">
        <img src="<?= $model->imageUrl ?>" class="img-responsive center-block" alt="<?= $model->name ?>">
    </div>
    <div class="col-md-8 col-sm-4 col-xs-6">
        <div class="row">
            <p class="text-capitalize">
                <a href="<?= Url::to(['article/view', 'controller' => 'news', 'rubric' => $model->category->slug, 'slug' => $model->slug]) ?>">
                    <?= $model->name ?>
                </a>
            </p>
            <p class="news-date"><?= Yii::$app->formatter->asDate($model->published_at,'php:d M yy') ?></p>
        </div>
    </div>
</div>
