<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */

$this->title = Yii::t('backend', 'Create {item}', [
    'item' => Yii::t('backend', 'Project Category'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Project Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="project-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>