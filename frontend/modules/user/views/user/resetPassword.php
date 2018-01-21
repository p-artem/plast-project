<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\ResetPasswordForm */

$this->context->layout = 'layout';

$this->title = Yii::t('site', 'Reset password');
?>

<div class="sign-wrap">

    <div class="title-wrap">
        <div class="h3-title"><?= Html::encode($this->title) ?></div>
    </div>

    <div class="sign-auth">
        <div class="row">

            <div class="col-md-6">
                <!-- <div class="sign-title">Новый покупатель</div> -->

                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'pass-rec reset-password'],
                    'fieldConfig' => [
                    'options' => [
                        'tag' => 'label',
                        'class' => 'cust-inp',
                        ],
                        'template' => '{input}{error}',
                        ],
                ]); ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder'=>$model->getAttributeLabel('password')]) ?>
                <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => $model->getAttributeLabel('password_confirm')]) ?>
                <div class="btn-wrap">
                    <?= Html::submitButton(Yii::t('site', 'Save'), ['class' => 'btn-accent']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div><!-- sign-wrap END -->
<?= $this->render('../../../../views/_inc/find-err') ?>