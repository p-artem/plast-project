<?php

use backend\helpers\Inflector;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $categories common\models\ProductCategory[] */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= \yii\bootstrap\Tabs::widget([
        'items' => [
                [
                    'label' =>  Yii::t('backend', 'Settings'),
                    'content' => $this->render('_form_main', [
                        'model' => $model,
                        'form' => $form,
                        'categories' => $categories,
                    ]),
                ],
                [
                    'label' =>  Yii::t('backend', 'Seo'),
                    'content' => $this->render('_form_seo', [
                        'model' => $model,
                        'form' => $form,
                    ]),
                ],
                [
                    'label' =>  Yii::t('backend', 'Gallery'),
                    'content' => $this->render('_form_gallery', [
                        'model' => $model,
                    ]),
                    'visible' => !$model->isNewRecord,
                ],
            ]
    ]) ?>

    <div class="form-group admin-button-save">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => 'btn-save ' . ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
