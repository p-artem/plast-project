<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->context->layout = 'layout';

$this->title = Yii::t('user', 'Sign up');
?>
<div class="sign-wrap">
    <!-- header-title-box -->
    <div class="title-wrap">
        <div class="h3-title"><?= Html::encode($this->title) ?></div>
    </div>

    <div class="sign-auth">
        <div class="row">

            <div class="col-md-6">

                <!-- <div class="sign-title">Новый покупатель</div> -->

                <?php $form = ActiveForm::begin([
                    'id' => 'signup-form',
//        'enableAjaxValidation'=>true,
                    'options' => ['class' => 'reg-signup'],
                    'fieldConfig' => [
                        'inputOptions' => ['class' => false],
                        'options' => [
                            'tag' => 'label',
                            'class' => 'cust-inp',
                        ],
                        'template' => '{input}{error}',
                    ],
                ]); ?>
                <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                <?= $form->field($model, 'phone_input')->widget(PhoneInput::className(), [
                    'jsOptions' => [
                        'allowExtensions' => true,
//            'onlyCountries' => ['ua'],
                        'preferredCountries' => ['ua'],
                        'separateDialCode' => true,
                        'nationalMode' => true
                    ]
                ]); ?>
                <?= $form->field($model, 'phone', ['options' => ['tag' => 'div', 'class' => ''], 'template' => '{input}'])->hiddenInput() ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => $model->getAttributeLabel('password_confirm')]) ?>

                <div class="check-line">
                    <?= $form->field($model, 'agreement', ['options' => ['class' => 'cust-check'],
                        'template' => '{input}<i class="check-ic"></i>'
                        . '<div class="check-descr">&nbsp;<span>' . Yii::t('user', 'I accept')
                        . '&nbsp;</span><a href="' . Url::toRoute('/terms-of-use') . '"><span>'
                        . Yii::t('user', 'the user agreement') . '</span></a></div>{error}'
                    ])
                        ->checkbox(['label' => false], false) ?>
                </div>

                <div class="btn-wrap">
                    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn-accent', 'name' => 'signup-button']) ?>
                </div>
                
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->render('../../../../views/_inc/find-err') ?>

<?php $this->registerJs("
$(\"#signup-form\").on('beforeValidate', function() {
  $(\"#signupform-phone\").val($(\"#signupform-phone_input\").intlTelInput(\"getNumber\"));
});
$('#signup-form').on('beforeSubmit', function (e) {
    ($(this).find('button[type=submit]').attr('disabled',true));
});
"); ?>