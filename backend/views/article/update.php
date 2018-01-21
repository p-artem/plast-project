<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories \common\models\ArticleCategory[] */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('backend', 'Article'),
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="article-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
