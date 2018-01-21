<?php
/* @var $model common\models\Article */

use yii\helpers\Url;
$articleUrl = Url::to(['article/view', 'controller' => 'news', 'rubric' => $model->category->slug, 'slug' => $model->slug]);
?>

<article class="blog-item">
    <a href="<?= $articleUrl ?>">
        <img class="img-responsive center-block" src="<?= $model->imageUrl ?>" alt="blog-item1">
        <div class="blog-heading">
            <h3><?= $model->name; ?></h3>
            <span class="date"><?= Yii::$app->formatter->asDate($model->published_at,'php:d M yy') ?></span>
        </div>
    </a>
    <p>
        <?= $model->short ?>
    </p>

    <a href="<?= $articleUrl ?>" class="text-capitalize ">
        <?= Yii::t('site', 'Read more')?>
        <span><i class="fa fa-angle-double-right"></i> </span>
    </a>
</article>