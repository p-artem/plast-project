<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\SystemLog;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SystemLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'System Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-log-index">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Clear'), false, ['class' => 'btn btn-danger', 'data-method'=>'delete']) ?>
    </p>
    <?php $ranges = [
        Yii::t('kvdrp', "Today") => ["moment().startOf('day')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "Yesterday") => ["moment().startOf('day').subtract(1,'days')", "moment().startOf('day')"],
        Yii::t('kvdrp', "Last {n} Days", ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "Last {n} Days", ['n' => 14]) => ["moment().startOf('day').subtract(13, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "This Month") => ["moment().startOf('month')", "moment().startOf('month').add({month:1})"],
        Yii::t('kvdrp', "Last Month") => ["moment().subtract({month:1}).startOf('day')", "moment().startOf('day').add({days:1})"],
    ]; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'prefix',
                'format' => 'raw',
                'value' => function (SystemLog $model) {
                    return Html::a($model->prefix, Url::to(['view', 'id' => $model->id]));
                },
            ],
            [
                'attribute' => 'category',
//                'format' => 'raw',
//                'value' => function (SystemLog $model) {
//                    return Html::a($model->category, Url::to(['view', 'id' => $model->id]));
//                },
                'filter'=>SystemLog::find()->select(['category'])->indexBy('category')->distinct()->asArray()->column()
            ],
            [
                'attribute'=>'level',
                'value'=>function ($model) {
                    return \yii\log\Logger::getLevelName($model->level);
                },
                'filter'=>[
                    \yii\log\Logger::LEVEL_ERROR => 'error',
                    \yii\log\Logger::LEVEL_WARNING => 'warning',
                    \yii\log\Logger::LEVEL_INFO => 'info',
                    \yii\log\Logger::LEVEL_TRACE => 'trace',
                    \yii\log\Logger::LEVEL_PROFILE_BEGIN => 'profile begin',
                    \yii\log\Logger::LEVEL_PROFILE_END => 'profile end'
                ]
            ],
//            'prefix',
            [
                'attribute' => 'log_time',
                'value' => 'log_time',
                'format' => 'datetime',
                'filter'=>\kartik\daterange\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'log_time',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'ranges' => $ranges,
                        'locale' => [
                            'format' => 'Y-m-d',
                        ],
                    ],
                ]),
            ],
//            [
//                'attribute' => 'log_time',
//                'format' => 'datetime',
//                'value' => function ($model) {
//                    return (int) $model->log_time;
//                }
//            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}'//{view}
            ]
        ]
    ]); ?>
    <?php Pjax::end(); ?>

</div>