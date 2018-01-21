<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PageSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

<!--    --><?php //echo $form->field($model, 'parent_id') ?>
<!---->
<!--    --><?php //echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'slug') ?>

<!--    --><?php //echo $form->field($model, 'h1') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'body') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'metatitle') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'metakeys') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'metadesc') ?>
<!---->
<!--    --><?php // echo $form->field($model, 'view') ?>

    <?php  echo $form->field($model, 'sorting') ?>

    <?php  echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
