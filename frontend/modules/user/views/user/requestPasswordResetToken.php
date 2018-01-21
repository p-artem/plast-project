<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\PasswordResetRequestForm */
$this->context->layout = 'layout';

$this->title = Yii::t('user', 'Request password reset');
?>
<div class="sign-wrap">

    <div class="title-wrap">
        <div class="h3-title"><?= Html::encode($this->title) ?></div>
    </div>

    <div class="sign-auth">

        <div class="sign-top-txt">
            <p><?= Yii::t('user', 'Enter the email address of your account.') ?></p>
            <p><?= Yii::t('user', 'Click the Send button to receive instructions on how to restore the password to e-mail.') ?></p>
        </div>

        <div class="row">

            <div class="col-md-6">
                <!-- <div class="sign-title">Новый покупатель</div> -->

                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'pass-rec'],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => 'label',
                            'class' => 'cust-inp',
                        ],
                        'template' => '{input}{error}',
                    ],
                ]); ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                <div class="btn-wrap">
                    <?= Html::submitButton(Yii::t('user', 'Send'), ['class' => 'btn-accent']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<?= $this->render('../../../../views/_inc/find-err') ?>
