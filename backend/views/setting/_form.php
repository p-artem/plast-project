<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'main_phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'main_email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
            <?= $form->field($model, 'google_location')->textInput(['maxlength' => true]) ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'coordinate_x')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'coordinate_y')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'status_site')->widget(SwitchInput::className(), [
                'type' => SwitchInput::CHECKBOX,
                'pluginOptions' => [
                    'size' => 'mini',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]); ?>

        </div>
        <div class="col-md-6">

            <?php if($model->price): ?>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-responsive">
                        <tbody>
                        <tr class="color-active">
                            <td><?= $model->price ?></td>
                            <td>
                                <?= Html::a('',
                                    [
                                        'remove-price',
                                        'id' => $model->primaryKey,
                                        'attribute' => 'price',
                                    ],[
                                        'class' => 'glyphicon glyphicon-trash',
                                        'data' => [
                                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                            'form' => '0',
                                        ],
                                    ]) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4"></div>
            </div>
            <?php endif ?>

            <?= $form->field($model, 'price')->fileInput()->label(false) ?>

            <?= $form->field($model, 'short')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'logo')->fileInput(['accept' => 'image/*']) ?>
            <?= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'logo']) ?>

            <?= $form->field($model, 'main_image')->fileInput(['accept' => 'image/*']) ?>
            <?= $this->render('/_inc/image-preview', ['model' => $model, 'attribute' => 'main_image']) ?>

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

<?php $this->registerJs('CKEDITOR.dtd.$removeEmpty.i = 0');
