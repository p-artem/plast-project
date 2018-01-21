<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Page
 * @var $products \common\models\Product[]
 * @var $categories array
 * @var $itemType string
 * @var $categoryslug string
 * @var $by string
 */

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use common\models\query\ProductQuery;

$this->params['breadcrumbs'] = $model->breadcrumbs();
$this->params['activeMenu'] = ['route'=>'page/view', 'slug' =>  $model->slug];
$this->title = $model->metatitle ?: $model->name;
$this->registerMetaTag(['name' => 'description', 'content' => $model->metadesc ?: $model->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->metakeys ?: $model->name]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
?>


<section class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class=""><?= $model->name ?></h2>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <div class="sel sel--black-panther">
                                <?= Html::dropDownList(
                                    'filterByCategorySlug',
                                    $categoryslug,
                                    ['' => Yii::t('site', 'All Products')] + $categories,
                                    [
                                        'onchange'=> 'filterByCategorySlug(this.value)',
                                        'prompt' => Yii::t('site', 'All Products'),
                                        'id' => 'select-profession'
                                    ]
                                ); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <div class="sel sel--superman">
                            <?= Html::dropDownList(
                                'filterByYear',
                                $by,
                                ['' => Yii::t('site', 'For All time')] + ProductQuery::getYearList(),
                                [
                                     'onchange'=> 'filterByYear(this.value)',
                                    'prompt' => Yii::t('site', 'For All time'),
                                    'id' => 'select-superpower'
                                ]
                            ); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php Pjax::begin(['id' => 'data-products', 'linkSelector'=>'.top-filter input']) ?>
        <div class="portfolio-item-list sorting-form">
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <?php $product->getImageUrl() ?>
                    <?php $productUrl = Url::to(['/product/view', 'controller' => 'catalog', 'categoryslug' => $product->category->slug, 'slug' => $product->slug]); ?>

                    <div class="col-md-4 col-sm-6">
                        <div class="portfolio-item">
                            <div class="item-image">
                                <a href="<?= $productUrl; ?>">
                                    <img src="<?= $product->getThumbUrl(); ?>" class="img-responsive center-block" alt="portfolio1">
                                    <div><span><i class="fa fa-plus"></i></span></div>
                                </a>
                            </div>

                            <div class="item-description">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <a href="<?= $productUrl; ?>" class="item-name">
                                            <?= $product->name; ?>
                                        </a>
                                        <a href="<?= Url::to('/' . $product->category->slug); ?>">
                                            <?= $product->category->name; ?>
                                        </a>
                                    </div>
                                    <div class="col-xs-4">
                                        <span class="like">
                                            <i class="fa fa-product-hunt"></i>
                                            <?= date('m-Y', $product->created_at); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php Pjax::end(); ?>

    </div>
</section>

<?php
$url = Url::to(['/product/index', 'controller' => 'catalog']);
$script = <<<JS
    function filterByYear(str) {
        var year = +str;
        year = (!isNaN(year) && year) ? '?by=' + year : '';
        var categorySlug = $('[name="filterByCategorySlug"]').val();
        year = (categorySlug) ? '/' + categorySlug + year : year;
        $.pjax.reload({url: '{$url}' + year, container: "#data-products"});
    }
    function filterByCategorySlug(str) {
        var categorySlug = (str) ? '/' + str : '';
        var year = $('[name="filterByYear"]').val();
        categorySlug += (!isNaN(year) && year) ? '?by=' + year : '';
       $.pjax.reload({url: '{$url}' + categorySlug, container: "#data-products"});
    }
JS;
$this->registerJs($script, \yii\web\View::POS_END);