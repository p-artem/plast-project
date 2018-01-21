<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\AccountForm */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::t('backend', 'Edit account')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'username') ?>

    <?php echo $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone_input')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
        'jsOptions' => [
            'allowExtensions' => true,
            'preferredCountries' => ['ua'],
            'separateDialCode'=> true,
            'nationalMode'=> true
        ]
    ]); ?>
    <?= $form->field($model, 'phone', ['template'=>'{input}','options'=>['tag'=>false]
    ])->hiddenInput() ?>

    <?php echo $form->field($model, 'password')->passwordInput() ?>

    <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs("
$(\"#{$form->id}\").submit(function() {
  $(\"#accountform-phone\").val($(\"#accountform-phone_input\").intlTelInput(\"getNumber\"));
});
"); ?>