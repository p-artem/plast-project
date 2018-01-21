<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 * @var $other_content string
 */

use yii\helpers\Url;

$this->title = $model->metatitle ?: $model->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: $model->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' => $model->slug];

?>

<section class="blog-content">
    <div class="container">
        <div class="row">
            <main class="col-md-12" style="display: block;">
                <article class="blog-item">
                    <?php if($model->getImageUrl()): ?>
                        <img class="img-responsive center-block" src="<?= $model->getImageUrl() ?>" alt="<?= $model->name ?>">
                    <?php endif; ?>
                    <div class="blog-heading text-center">
                        <h3><?= ($model->h1) ? $model->h1 : $model->name; ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           <?= $model->text ?>
                        </div>
                    </div>
                </article>
            </main>
        </div>
    </div>
</section>