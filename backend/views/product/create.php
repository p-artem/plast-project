<?php
/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $categories common\models\ProductCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'Product'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="page-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
