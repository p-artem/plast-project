<?php
/* @var $this yii\web\View */
/* @var $model \common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */

?>

<?= $form->field($model, 'metatitle')->textInput(); ?>

<?= $form->field($model, 'metakeys')->textarea(); ?>

<?= $form->field($model, 'metadesc')->textarea(); ?>
