<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\switchinput\SwitchInput;
use common\models\PageMenu;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategory */
/* @var $form yii\bootstrap\ActiveForm */

?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',  ['forcePasteAsPlainText'=>true,'allowedContent' => true,/* Some CKEditor Options */])
]) ?>

<?= $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
    ->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'sorting')->textInput() ?>

<?= $form->field($model, 'status')->widget(SwitchInput::className(), [
    'type' => SwitchInput::CHECKBOX,
    'pluginOptions' => [
        'size' => 'mini',
        'onColor' => 'success',
        'offColor' => 'danger',
    ]
]); ?>