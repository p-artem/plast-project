<?php

use common\grid\EnumColumn;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'User'),
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
//            'id',
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function (User $model) {
                    return Html::a($model->id, Url::to(['update', 'id' => $model->id]), ['data-pjax' => 0]);
                },
            ],
            'username',
            'email:email',
            'phone',
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => User::statuses(),
                'filter' => User::statuses()
            ],
            [
                'label' => Yii::t('backend', 'Role'),
                'attribute' => 'role',
                'filter' => User::roles(),
                'value' => 'role'
            ],
            'created_at:datetime',
            'logged_at:datetime',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}' //{view}{update}
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
