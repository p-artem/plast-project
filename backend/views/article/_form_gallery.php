<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap\ActiveForm */
?>
<div class="form-group">
    <label class="control-label"><?= Yii::t('backend', 'Photo') ?></label>

    <?= \backend\widgets\GalleryManager::widget(
        [
            'model' => $model,
            'behaviorName' => 'gallery',
            'apiRoute' => 'article/galleryApi'
        ]
    ) ?>
</div>
