<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->context->layout = 'layout';

$this->title = Yii::t('user', 'Sign In');
?>
<div class="sign-wrap">

    <div class="title-wrap">
        <div class="h3-title"><?= Yii::t('user', 'Sign In') ?></div>
    </div>

    <div class="sign-auth">
        <div class="row">

            <div class="col-md-6">

                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'login-form'],
                    'fieldConfig' => [
                        'options' => [
                            'tag' => 'label',
                            'class' => 'cust-inp',
                        ],
                        'template' => '{input}{error}',
                    ],
                ]); ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                <div class="check-line">
                    <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'cust-check']])
                        ->checkbox(['template' => '{input}<i class="check-ic"></i>']) ?>
                    <div class="check-descr">
                        <span><?= Yii::t('user', 'Remember Me') ?></span>
                    </div>
                </div>

                <div class="entry-line">

                    <div class="pass-forgot">
                        <a href="<?= Url::to(['/user/request-password-reset']) ?>"><span><?= Yii::t('user', 'Forgot password?') ?></span></a>
                    </div>

                    <div class="btn-wrap">
                        <?= Html::submitButton(Yii::t('user', 'Log In'), ['class' => 'btn-accent', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    
<?= $this->render('../../../../views/_inc/find-err') ?>

<?php $this->registerJs("
$('#login-form').on('beforeSubmit', function (e) {
    ($(this).find('button[type=submit]').attr('disabled',true));
});
"); ?>