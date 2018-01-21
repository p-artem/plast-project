<?php
/**
 * @var $this \yii\web\View
 * @var $contactForm \frontend\models\ContactForm
 * @var $messageTitle string
 * @var $status bool
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php \yii\widgets\Pjax::begin([
    'id' => 'pjax-contact',
    'linkSelector' => false,
    'enablePushState' => false,
    'formSelector'  => '#contact-us-form'
])?>

<?php if ($status): ?>
    <?php
    $message = Yii::t('site', 'Message send successfully!');
    $this->registerJs(<<<JS
    var popup = $('[pd-popup="popupSubscribe"]');
    popup.find('.text-message').text('{$message}');
    popup.fadeIn(100);
JS
)?>
<?php endif ?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-us-form',
    'action' => Url::to(['/contact/contact']),
    'enableAjaxValidation' => false,
    'options' => [
        'class' => 'contact-form',
        'data-pjax' => true,
    ],
    'fieldConfig' => function($model, $attribute){

        return [
            'inputOptions'=>['class'=>'form-control', 'required' => true],
            'options' => [
                'tag' => 'div',
                'class' => 'form-group',
            ],
            'template'=>'{input}{error}',
        ];
    }
]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($contactForm, 'name')->textInput(['placeholder' => Yii::t('site', 'Name')]); ?>
            <?= $form->field($contactForm, 'surname')->textInput(['placeholder' => Yii::t('site', 'Surname')]); ?>
            <?= $form->field($contactForm, 'email')->textInput(['placeholder' => Yii::t('site', 'Email')]); ?>
        </div>

        <div class="col-md-8">
            <?= $form->field($contactForm, 'message')->textarea(['rows' => 8,'placeholder' => Yii::t('site', 'Type here message')]); ?>
        </div>
    </div>

    <?= Html::submitButton(Yii::t('site', 'Submit'), ['class' => 'btn btn-black']); ?>

    <?php ActiveForm::end(); ?>

<?php \yii\widgets\Pjax::end() ?>

<?php

$script = <<<JS
    $(document).on('pjax:success', function() {
          $('#notice-modal').modal('show');
        });
    $(document).on('pjax:beforeSend', function (event, xhr, settings) {
        $('#contact-us-form [type="submit"]').attr('disabled', 'disabled');
    });
    $(document).on('pjax:error', function() {
        $('#error-modal').modal('show');
        $('#contact-us-form [type="submit"]').removeAttr('disabled');
    });
JS;

$this->registerJs($script, \yii\web\View::POS_READY);

?>
