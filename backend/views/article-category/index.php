<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pheme\grid\ToggleColumn;
use yii\helpers\Url;
use common\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Article Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

    <?//= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create {modelClass}', [
            'modelClass' => Yii::t('backend', 'ArticleCategory'),
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'rowOptions' => function (ArticleCategory $model)
        {
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (ArticleCategory $model) {
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
