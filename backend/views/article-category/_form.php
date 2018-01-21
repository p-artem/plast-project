<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $categories array */
?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= \yii\bootstrap\Tabs::widget([
        'items' =>[
                [
                    'label' =>  Yii::t('backend', 'Settings'),
                    'content' => $this->render('_form_main', [
                        'model' => $model,
                        'categories' => $categories,
                        'form' => $form,
                    ]),
                ],
                [
                    'label' =>  Yii::t('backend', 'Seo'),
                    'content' => $this->render('_form_seo', [
                        'model' => $model,
                        'form' => $form,
                    ]),
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
