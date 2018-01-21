<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ProductCategory;
use pheme\grid\ToggleColumn;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */
/* @var $searchModel backend\models\search\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Product Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}', ['modelClass' => Yii::t('backend','ProductCategory')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'rowOptions' => function (ProductCategory $model)
        {
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (ProductCategory $model) {
                    return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                },
            ],
            'slug',
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{delete}'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>