<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->context->layout = 'layout';

$this->title = Yii::t('user', 'Signup success');
?>
<div class="sign-wrap">
    <div class="title-wrap">
        <div class="h3-title"><?= Yii::t('user', 'Signup success') ?></div>
    </div>
    <div class="sign-auth">
        <div class="sign-top-txt">
            <p><?= Yii::t('user', 'Thank you for registering') ?>!</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="btn-wrap">
                    <a href="/" class="btn-accent"><?= Yii::t('site', 'To home') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('../../../../views/_inc/find-err') ?>