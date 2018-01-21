<?php

use kartik\switchinput\SwitchInput;
use trntv\yii\datetime\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $suffix string */
/* @var $categories \common\models\ArticleCategory[]*/

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
        ), ['prompt'=>'']) ?>

        <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'published_at')->widget(
            DateTimeWidget::className(),
            [
                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
            ]
        ) ?>

        <?= $form->field($model, 'popular')->widget(SwitchInput::className(), [
            'type' => SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'size' => 'mini',
                'onColor' => 'success',
                'offColor' => 'danger',
            ]
        ]); ?>

        <?= $form->field($model, 'status')->widget(SwitchInput::className(), [
            'type' => SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'size' => 'mini',
                'onColor' => 'success',
                'offColor' => 'danger',
            ]
        ]); ?>



    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'short')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <?= $this->render('/_inc/image-preview.php', ['model' => $model, 'attribute' => 'image']) ?>

    </div>
</div>



<?= $form->field($model, 'text')->widget(\mihaildev\ckeditor\CKEditor::className(), [
    'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',  ['forcePasteAsPlainText'=>true,'allowedContent' => true,/* Some CKEditor Options */])
]) ?>










