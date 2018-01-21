<?php

use yii\helpers\Url;
use common\models\Page;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;
use backend\helpers\ToggleMenuColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}',
            ['modelClass' => Yii::t('backend', 'Page'),]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model)
        {
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'formatter' => [
            'class' => \yii\i18n\Formatter::className(),
            'nullDisplay' => '',
        ],
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
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' //{update}
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>