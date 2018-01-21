<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Social */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Social',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Socials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="social-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>