<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $itemType string */

use yii\helpers\Url;
use common\models\Article;
use common\models\query\ArticleQuery;
use common\models\ArticleCategory;


$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' => 'news'];

$this->title = $model->metatitle ?: $model->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: $model->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);

?>

<section class="blog-content">
    <div class="container">
        <div class="row">
            <main class="col-md-9 col-md-push-3" style="display: block;">
                <article class="blog-item">
                    <img class="img-responsive center-block" src="<?= $model->imageUrl ?>" alt="blog-featured-image">
                    <div class="blog-heading">
                        <h3 class="text-capitalize"><?= $model->name ?></h3>
                        <span class="date"><?= Yii::$app->formatter->asDate($model->published_at,'php:d M yy') ?></span>
                    </div>
                    <?= $model->text ?>

                    <div class="single-blog-page-button">
                        <div class="row">

                            <?php if (!empty($prevNext = $model->getPrevNext())) : ?>
                                <?php foreach ($prevNext as $key => $article) : ?>
                                    <?php
                                    $articleUrl = Url::to(['article/view', 'controller' => 'news', 'rubric' => $article->category->slug, 'slug' => $article->slug]);
                                    $letter = ($key%2 == 0) ? Yii::t('site','Previous Post') : Yii::t('site','Next Post');
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

                <?php
                    $popularPost = Article::find()->active()->orderByPublished()->byPopular()->limit(2)->all();
                ?>

                <div class="tab-widget">
                    <h4><? Yii::t('site', 'News digest') ?></h4>
                    <div  class="nav-tabs-default">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#recent" data-toggle="tab">
                                    <div class="tab-widget-title"><?= Yii::t('site', 'Recent Post')?></div>
                                </a>
                            </li>
                            <?php if($popularPost) :?>
                                <li>
                                    <a href="#popular" data-toggle="tab">
                                        <div class="tab-widget-title"><?= Yii::t('site', 'Popular Post')?></div>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="recent">
                                <?php foreach (Article::find()->active()->orderByPublished()->limit(2)->all() as $article): ?>
                                    <?= $this->render('_item_mini', ['model' => $article, 'id' => 'recent']) ?>
                                <?php endforeach; ?>
                            </div>

                            <?php if($popularPost) :?>
                                <div class="tab-pane" id="popular">
                                    <?php foreach ($popularPost as $article): ?>
                                        <?= $this->render('_item_mini', ['model' => $article, 'id' => 'popular']) ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="archive-widget">
                    <h4><?= Yii::t('site', 'Rubrics') ?></h4>
                    <ul class="archives">
                        <li>
                            <a href="<?= Url::to(['article/index',  'controller' => 'news'])?>" title="<?= Yii::t('site', 'View all posts')?>">
                                <?= Yii::t('site', 'All') ?>
                            </a>
                        </li>
                        <?php foreach (ArticleCategory::find()->select(['name', 'slug'])->active()->getAllAsTree() as $item): ?>
                            <li >
                                <a href="<?= Url::to(['article/index',  'controller' => 'news', 'rubric' => $item['slug']])?>" title="<?= $item['name'] ?>">
                                    <?= $item['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php if($popularTags = Article::getPopularTags()): ?>
                    <div class="tag-widget">
                        <h4><?= Yii::t('site', 'Popular Tags')?></h4>
                        <div class="tags">
                            <?php foreach ($popularTags as $tag): ?>
                                <a href="<?= Url::to(['article/index',  'controller' => 'news', 'tag' => $tag])?>"><?= $tag ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="archive-widget">
                    <h4><?= Yii::t('site', 'Archives') ?></h4>
                    <ul class="archives">
                        <li>
                            <a href="<?= Url::to(['article/index',  'controller' => 'news'])?>" title="<?= Yii::t('site', 'View all posts')?>">
                                <?= Yii::t('site', 'All') ?>
                            </a>
                        </li>
                        <?php foreach (ArticleQuery::getYearList() as $year): ?>
                            <li>
                                <a href="<?= Url::to(['article/index',  'controller' => 'news', 'year' => $year])?>" title="<?= Yii::t('site', 'View all posts from {data}', ['date' => $year])?>">
                                    <?= $year ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>