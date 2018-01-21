<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\switchinput\SwitchInput;
use common\models\PageMenu;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $suffix string */

?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <div class="row">
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
            <div class="col-md-4">
                <?= $form->field($model, 'sorting')->textInput() ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'menusArray')->checkboxList(PageMenu::menus()) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <?= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'image']) ?>
    </div>
</div>

<?= $form->field($model, 'text')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',  ['forcePasteAsPlainText'=>true, 'allowedContent' => true/* Some CKEditor Options */])
]) ?>

<?php $this->registerJs('CKEDITOR.dtd.$removeEmpty.i = 0');


