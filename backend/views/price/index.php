<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;
use common\models\Price;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Price */

$this->title = Yii::t('backend', 'Prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div style="width: 50%; margin-bottom: 30px">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>



<?php Pjax::begin(); ?>
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
        'rowOptions' => function (Price $model){
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'file',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->file, Url::to(['download', 'id' => $model->id]), ['data-pjax' => '0']);
                },
            ],
            'sorting',
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
             'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' //{update}
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
