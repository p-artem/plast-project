<?php

use kartik\switchinput\SwitchInput;
use trntv\yii\datetime\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $categories \common\models\ArticleCategory[] */
/* @var $suffix string */

?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


<?= $form->field($model, 'text')->widget(\mihaildev\ckeditor\CKEditor::className(), [
    'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',
        ['forcePasteAsPlainText'=>true,'allowedContent' => true,/* Some CKEditor Options */]),
]) ?>

    <?= $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => 1024]) ?>


    <?= $form->field($model,'sorting')->textInput() ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::className(), [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions' => [
            'size' => 'mini',
            'onColor' => 'success',
            'offColor' => 'danger',
        ]
    ]); ?>
