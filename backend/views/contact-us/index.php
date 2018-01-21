<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;
use common\models\Contact;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <?php Pjax::begin(); ?>

    <?php $ranges = [
        Yii::t('kvdrp', "Today") => ["moment().startOf('day')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "Yesterday") => ["moment().startOf('day').subtract(1,'days')", "moment().startOf('day')"],
        Yii::t('kvdrp', "Last {n} Days", ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "Last {n} Days", ['n' => 14]) => ["moment().startOf('day').subtract(13, 'days')", "moment().startOf('day').add({days:1})"],
        Yii::t('kvdrp', "This Month") => ["moment().startOf('month')", "moment().startOf('month').add({month:1})"],
        Yii::t('kvdrp', "Last Month") => ["moment().subtract({month:1}).startOf('day')", "moment().startOf('day').add({days:1})"],
    ]; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'rowOptions' => function (Contact $model)
        {
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'fullName',
                'format'    => 'raw',
                'value' => function (Contact $model) {
                    return Html::a($model->getFullName(), Url::to(['update', 'id' => $model->id]));
                },
            ],
            'email',
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],

            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'format' => 'datetime',
                'filterType'=>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>[
                        'ranges' => $ranges,
                        'locale'=>[
                            'format'=>'Y-MM-DD',
//                            'separator'=>' to ',
                        ],
//                        'opens'=>'left'
                    ]
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}', //{view}
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>