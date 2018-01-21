<?php
/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Contact us',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contact us'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Create');
?>
<div class="contact-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>