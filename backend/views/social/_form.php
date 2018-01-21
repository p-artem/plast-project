<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Social */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
    <?= $this->render('/_inc/image-preview.php', ['model' => $model, 'attribute' => 'image']) ?>

    <?= $form->field($model, 'sorting')->textInput() ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::className(), [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions' => [
            'size' => 'mini',
            'onColor' => 'success',
            'offColor' => 'danger',
        ]
    ]); ?>

    <div class="form-group admin-button-save">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => 'btn-save ' . ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>