<?php
/**
 * @var $model \common\models\Article
 * @var $id string
 */

use yii\helpers\Url;
?>

<div class="recent-post" id="<?=$id ?>">
    <?php $short = substr($model->short, 0, strpos($model->short, '.') + 1)?>
    <a href="<?= Url::to(['article/view', 'controller' => 'news', 'rubric' => $model->category->slug, 'slug' => $model->slug]) ?>">
        <img src="<?= $model->imageUrl ?>" class="img-responsive center-block" alt="<?= $model->name ?>">
        <h5 class="post-widget-heading">
            <?= $model->name ?>
        </h5>
    </a>
    <span class="date"><?= Yii::$app->formatter->asDate($model->published_at,'php:d M yy') ?></span>
    <p>
        <?= $short ?>
    </p>
</div>