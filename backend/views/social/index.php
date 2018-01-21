<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SocialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Socials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => Yii::t('backend','Social'),
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                },
            ],
            'link',
            'sorting',
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>