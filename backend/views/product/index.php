<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Product;
use pheme\grid\ToggleColumn;
use backend\helpers\ToggleMenuColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}',
            ['modelClass' => Yii::t('backend', 'Product')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'formatter' => [
            'class' => \yii\i18n\Formatter::className(),
            'nullDisplay' => '',
        ],
        'rowOptions' => function (Product $model){
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                },
            ],
            'slug',
            'sorting',
            [
                'attribute' => 'on_main',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleMenuColumn::className(),
            ],
//            'image_slider',
            'created_at:datetime',
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' //{update}
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>