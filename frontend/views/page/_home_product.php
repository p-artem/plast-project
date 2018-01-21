<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\Product */

use yii\helpers\Url;

$url = Url::to(['/product/view', 'controller' => 'catalog', 'categoryslug' => $model->category->slug, 'slug' => $model->slug])
?>

<div class="col-md-4 col-sm-6">
    <div class="portfolio-item">
        <div class="item-image">
            <a href="<?= $url ?>">
                <img src="<?= $model->getImageUrl() ?>" class="img-responsive center-block" alt="portfolio1">
                <div><span><i class="fa fa-plus"></i></span></div>
            </a>
        </div>
        <div class="item-description">
            <div class="row">
                <div class="col-xs-8">
                    <span class="item-name">
                        <?= $model->name ?>
                    </span>
                    <span>
                        <?= $model->category->name ?>
                    </span>
                </div>
                <div class="col-xs-4">
                   <span class="like">
                       <i class="fa fa-product-hunt"></i>
                       <?= date('m-Y', $model->created_at); ?>
                   </span>
                </div>
            </div>
        </div>
    </div>
</div>
