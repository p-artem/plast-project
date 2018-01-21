<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'position')->dropDownList(\common\models\Slider::getPositions()); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'sorting')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'on_main')->widget(SwitchInput::className(), [
                        'type' => SwitchInput::CHECKBOX,
                        'pluginOptions' => [
                            'size' => 'mini',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ]
                    ]); ?>
                </div>
                <div class="col-md-6">
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
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
            <?= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'image']) ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',  ['forcePasteAsPlainText'=>true,'allowedContent' => true,/* Some CKEditor Options */])
    ]) ?>

    <div class="form-group admin-button-save">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => 'btn-save ' . ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>