<?php
/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('backend', 'Contact Us'),
]) . ' ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contact us'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="contact-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>