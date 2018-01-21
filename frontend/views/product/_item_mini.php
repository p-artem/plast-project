<?php
/**
 * @var $model \common\models\Product
 * @var $id string
 */

use yii\helpers\Url;
?>

<div class="recent-post" id="<?=$id ?>">
    <a href="<?= Url::to(['product/view', 'controller' => 'catalog', 'categoryslug' => $model->category->slug, 'slug' => $model->slug]) ?>">
        <img src="<?= $model->getImageUrl() ?>" class="img-responsive center-block" alt="<?= $model->name ?>">
        <h5 class="post-widget-heading">
            <?= $model->name ?>
        </h5>
    </a>
    <p><?= $model->short ?></p>
</div>