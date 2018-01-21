<?php

use pheme\grid\ToggleColumn;
use common\models\ArticleCategory;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\Article;
use kartik\select2\Select2;
use backend\helpers\ToggleMenuColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <p>
        <?= Html::a(
            Yii::t('backend', 'Create {modelClass}', ['modelClass' => Yii::t('backend', 'Article')]),
            ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['linkSelector' => 'thead a, .pagination a']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'rowOptions' => function (Article $model)
        {
            return ['class' => 'color-'.($model->status ? 'active' : 'inactive')];
        },
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function (Article $model) {
                    return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
                },
            ],
            'slug',
            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'filter' => Select2::widget([
                    'data' => ArticleCategory::find()->getList(),
                    'attribute' => 'category_id',
                    'model' => $searchModel,
                    'options' => ['placeholder' =>  Yii::t('backend', 'All')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '150'
                    ],
                ]),
            ],
            [
                'attribute' => 'popular',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleMenuColumn::className(),
            ],
            [
                'attribute' => 'created_by',
                'value' => 'author.username',
                'filter' => Select2::widget([
                    'data' => Article::find()->authorList(),
                    'attribute' => 'created_by',
                    'model' => $searchModel,
                    'options' => ['placeholder' =>  Yii::t('backend', 'All')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100'
                    ],
                ]),
            ],
            [
                'attribute' => 'status',
                'filter' => [1 => Yii::t('backend', 'On'), 0 => Yii::t('backend', 'Off')],
                'class' => ToggleColumn::className(),
            ],
            'published_at:datetime',
            'created_at:datetime',


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ]
        ]
    ]); ?>
    <?php Pjax::end()?>
</div>