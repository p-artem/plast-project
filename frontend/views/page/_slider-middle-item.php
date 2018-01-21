<?php
/** @var $model \common\models\Slider */
?>

<div class="item text-center">
    <div class="twit-content">
        <div class="twit-icon">
            <i class="fa fa-cubes"></i>
        </div>
        <?= $model->text ?>
        <p>
            <?= Yii::$app->appSettings->settings->name ?> <br/>
            <?= Yii::$app->appSettings->settings->main_email ?>
        </p>
    </div>
</div>
