<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\Article|common\models\Page|common\models\UserProfile
 * @var $attribute string
 */
if (empty($attribute)){
    $imageUrl = $model->imageUrl;
} else {
    $imageUrl = $model->getImageUrl($attribute);
}
?>
<?php if (!$model->isNewRecord && $imageUrl): ?>
    <div class="clearfix">
        <div class="preview">
            <?= Html::img($imageUrl) ?>
            <?= Html::a('',
                [
                    'remove-image',
                    'id' => $model->primaryKey,
                    'attribute' => $attribute,
                ],[
                    'class' => 'glyphicon-remove-circle glyphicon',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                        'form' => '0',
                    ],
                ]) ?>
        </div>
    </div>
<?php endif; ?>