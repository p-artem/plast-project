<?php

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone_input')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
        'jsOptions' => [
            'allowExtensions' => true,
            'preferredCountries' => ['ua'],
            'separateDialCode'=> true,
            'nationalMode'=> true
        ]
    ]); ?>
    <?= $form->field($model, 'phone', ['template' => '{input}', 'options' => ['tag' => false]
    ])->hiddenInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'status')->dropDownList(User::statuses()) ?>
    <?= $form->field($model, 'roles')->checkboxList($roles) ?>

    <div class="form-group admin-button-save">
        <?= Html::submitButton(
            $model->getModel()->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => 'btn-save ' . ($model->getModel()->isNewRecord ? 'btn btn-success' : 'btn btn-primary')]) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs("
$(\"#{$form->id}\").on('beforeValidate', function() {
  $(\"#userform-phone\").val($(\"#userform-phone_input\").intlTelInput(\"getNumber\"));
  console.log(345);
});
"); ?>