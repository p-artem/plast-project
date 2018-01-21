<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\KeyStorageItem;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\KeyStorageItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Key Storage Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="key-storage-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Key Storage Item',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'key',
            [
                'attribute' => 'key',
                'format' => 'raw',
                'value' => function (KeyStorageItem $model) {
                    return Html::a($model->key, Url::to(['update', 'id' => $model->key]), ['data-pjax' => 0]);
                },
            ],
            'value',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' //{update}
            ],
        ],
    ]); ?>

</div>
