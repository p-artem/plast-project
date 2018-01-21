<?php
/* @var $this \yii\web\View */
/* @var $model\frontend\models\SubscribeForm */
/* @var $message string */

use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<div class="subscr-foot">
    <span class="hidden subscribe-message">
        <?= $message ?>
    </span>

    <h4><?= Yii::t('site', 'E-News-Letter') ?></h4>

    <p><?= Yii::t('site', 'Sign up for our mailing list to get latest updates and offers') ?></p>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/contact/subscribe']),
        'options' => [
            'id' => Yii::$app->security->generateRandomString(8),
            'class' => 'subscr-foot-form',
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => 'label',
            ],
            'template' => '{input}{error}',
        ],
    ]); ?>

    <?= $form->field($model, 'email', [
        'template' => "<div class='input-group margin-bottom-sm'>{input}
                          <span class=\"input-group-addon\" data-action=\"subscribe\">
                                        <i class=\"fa fa-paper-plane fa-fw\"></i>
                                    </span>
                                    </div>
                        {error}",
    ])->textInput([
        'placeholder' => $model->getAttributeLabel('email'),
        'type' => 'email',
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>
