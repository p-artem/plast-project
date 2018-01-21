<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap\ActiveForm */
?>
<div class="form-group">
    <label class="control-label"><?= Yii::t('backend', 'Photos') ?></label>

    <?= \backend\widgets\GalleryManager::widget(
        [
            'model' => $model,
            'behaviorName' => 'gallery',
            'apiRoute' => 'product/galleryApi'
        ]
    ) ?>
</div>
