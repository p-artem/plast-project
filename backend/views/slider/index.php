<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;
use backend\helpers\ToggleMenuColumn;
use common\models\Slider;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'Slider'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'formatter' => [
            'class' => \yii\i18n\Formatter::className(),
            'nullDisplay' => '',
        ],
        'rowOptions' => function (Slider $model){
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (Slider $model) {
                    return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                },
            ],
            [
                'attribute' => 'position',
                'filter' => Slider::getPositions(),
                'value' => function (Slider $model) {
                    return ArrayHelper::getValue(Slider::getPositions(), $model->position);
                },

            ],
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
            'sorting',
            [
                'attribute' => 'on_main',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleMenuColumn::className(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}', //{view}
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>