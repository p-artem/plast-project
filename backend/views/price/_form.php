<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
/* @var $this yii\web\View */
/* @var $model common\models\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'sorting')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->widget(SwitchInput::className(), [
                'type' => SwitchInput::CHECKBOX,
                'pluginOptions' => [
                    'size' => 'mini',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Upload') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
