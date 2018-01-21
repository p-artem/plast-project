<?php
/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $page common\models\Page */
/* @var $itemType string */

use yii\helpers\Url;
use common\models\ProductCategory;
use common\models\Product;

$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' => 'catalog'];

$this->title = $model->metatitle ?: $model->name;
$metadesc = $model->metadesc ?: $model->name;

$this->registerMetaTag(['name' => 'description', 'content' => $metadesc]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);

$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
if ($metadesc) $this->registerMetaTag(['property' => 'og:description', 'content' => $metadesc]);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
$this->registerMetaTag(['property' => 'og:site_name', 'content' => Yii::$app->name]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::canonical()]);

$image = ($image = $model->getImageUrl()) ? Yii::$app->urlManager->createAbsoluteUrl($image) : null ;
if ($image) {
    $this->registerMetaTag(['property' => 'og:image', 'content' => $image]);
}
?>


<section class="blog-content">
    <div class="container">
        <div class="row">
            <main class="col-md-9 col-md-push-3" style="display: block;">
                <article class="blog-item">
                    <?php if($gallery = $model->getGallery()): ?>
                        <?php if(count($gallery) < 2): ?>
                            <div class="proj-slider-wrap">
                                <div class="proj-slide" style="background-image: url(<?= $gallery[0]->getUrl('original'); ?>);">
                                    <img src="/img/projects/_slider/_proj_rect.png" alt="product">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="proj-slider-wrap">
                                <div class="proj-slider">
                                    <?php foreach ($model->getGallery() as $item): ?>
                                        <div class="proj-slide" style="background-image: url(<?= $item->getUrl('original'); ?>);">
                                            <img src="/img/projects/_slider/_proj_rect.png" alt="product">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="proj-slider-wrap">
                            <div class="proj-slide" style="background-image: url(<?= $model->getImageUrl(); ?>);">
                                <img src="/img/projects/_slider/_proj_rect.png" alt="product">
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="blog-heading text-center">
                        <h3><?= $model->name ?></h3>
                    </div>
                    <?= $model->text ?>

                    <div class="single-blog-page-button">
                        <div class="row">

                            <?php if (!empty($prevNext = $model->getPrevNext())) : ?>
                                <?php foreach ($prevNext as $key => $article) : ?>
                                    <?php
                                    $articleUrl = Url::to(['product/view', 'controller' => 'catalog', 'categoryslug' => $article->category->slug, 'slug' => $article->slug]);
                                    $letter = ($key%2 == 0) ? Yii::t('site','Previous Product') : Yii::t('site','Next Product');
                                    $class = ($key%2 == 0) ? 'left' : 'right';
                                    ?>

                                    <div class="col-md-6">
                                        <a href="<?= $articleUrl ?>" class="btn blog-btn">
                                            <span><i class="fa fa-long-arrow-<?= $class ?>"></i></span>
                                            <?= $letter ?>
                                        </a>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </main>

            <aside class="col-md-3 col-md-pull-9">

                <?php $popularProducts = Product::find()->active()->limit(2)->all(); ?>

                <div class="tab-widget">
                    <h4><? Yii::t('site', 'Products digest') ?></h4>
                    <div  class="nav-tabs-default">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#recent" data-toggle="tab">
                                    <div class="tab-widget-title"><?= Yii::t('site', 'Recent Products')?></div>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="recent">
                                <?php foreach (Product::find()->active()->orderLatest()->limit(2)->all() as $article): ?>
                                    <?= $this->render('_item_mini', ['model' => $article, 'id' => 'recent']) ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="archive-widget">
                    <h4><?= Yii::t('site', 'Categories') ?></h4>
                    <ul class="archives">
                        <li>
                            <a href="<?= Url::to(['article/index',  'controller' => 'news'])?>" title="<?= Yii::t('site', 'View all posts')?>">
                                <?= Yii::t('site', 'All') ?>
                            </a>
                        </li>
                        <?php foreach (ProductCategory::find()->select(['name', 'slug'])->active()->asArray()->all() as $item): ?>
                            <li >
                                <a href="<?= Url::to(['product/index',  'controller' => 'catalog', 'categoryslug' => $item['slug']])?>" title="<?= $item['name'] ?>">
                                    <?= $item['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>