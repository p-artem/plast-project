<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\switchinput\SwitchInput;
use trntv\yii\datetime\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $categories common\models\ProductCategory[] */
/* @var $suffix string */

?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug')
            ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
            ->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'name'
        )); ?>

        <?= $form->field($model, 'created_at')->widget(
            DateTimeWidget::className(),
            [
                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
            ]
        ) ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'sorting')->textInput() ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'on_main')->widget(SwitchInput::className(), [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginOptions' => [
                        'size' => 'mini',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ]
                ]); ?>
            </div>
            <div class="col-md-4">
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
        <?= $form->field($model, 'short')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <?= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'image']) ?>
    </div>
</div>



<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',  ['forcePasteAsPlainText'=>true,'allowedContent' => true,/* Some CKEditor Options */])
]) ?>







<!---->
<!--    --><?//= $form->field($model, 'image_slider')->fileInput(['accept' => 'image/*']) ?>
<!--    --><?//= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'image_slider']) ?>

<!--    --><?//= $form->field($model, 'on_main')->widget(SwitchInput::className(), [
//        'type' => SwitchInput::CHECKBOX,
//        'pluginOptions' => [
//            'size' => 'mini',
//            'onColor' => 'success',
//            'offColor' => 'danger',
//        ]
//    ]); ?>



