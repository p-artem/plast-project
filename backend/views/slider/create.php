<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => Yii::t('backend', 'Slider'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="slider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>