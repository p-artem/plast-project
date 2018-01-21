<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\ArticleCategory|\common\models\Page
 * @var $modelArticleCategory ArticleCategory|null
 * @var $searchModel \frontend\models\search\ArticleSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $itemType string
 * @var $year string
 */

use yii\helpers\Url;
use common\models\ArticleCategory;
use yii\widgets\Pjax;
use common\models\query\ArticleQuery;
use common\models\Article;

$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' => $itemType];
$this->title = $model->metatitle ?: $model->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: $model->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>

<section class="blog-content">
    <div class="container">
        <div class="row">
            <main class="col-md-9 col-md-push-3" style="display: block;">


                <?php Pjax::begin([
                    'formSelector' => '#news-list',
                    'linkSelector' => '.listPagination a',
                    'options'      => ['class' => 'post-lst']
                ]) ?>

                <?= \frontend\widgets\SiteListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView'     => '_item',
                    'layout'       => '{items}<div class="row"><div class= "col-md-6 col-md-offset-3 text-center">{pager}</div></div>',
                    'options'      => ['tag' => false],
                    'itemOptions'  => [],
                    'emptyText'    => '<div class="container">'.Yii::t('search', 'No results found.').'</div>',
                ]) ?>
                <?php Pjax::end() ?>

<!--                    <div class="row">-->
<!--                        <div class="col-md-12">-->
<!--                            <blockquote>-->
<!--                                <p>Duis eget ultricies lorem, et rhoncus augue. Aliquam id est semper, tincidunt nisi ac, tristique enim. Phasellus accumsan, enim eget facilisis mollis, est orcidearn malesuada libero, at tristique ligula nulla id eros hasellus accumsan.</p>-->
<!--                                <footer>Technext</footer>-->
<!--                            </blockquote>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
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
                            <li class="<?= $year == $item ? 'active' : ''; ?>">
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
                        <?php foreach (ArticleQuery::getYearList() as $item): ?>
                            <li class="<?= $year == $item ? 'active' : ''; ?>">
                                <a href="<?= Url::to(['article/index',  'controller' => 'news', 'year' => $item])?>" title="<?= Yii::t('site', 'View all posts from {data}', ['date' => $item])?>">
                                    <?= $item ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

