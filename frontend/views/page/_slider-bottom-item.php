<?php
/** @var $model \common\models\Slider */
?>

<div class="col-md-6">
    <div class="client-box">
        <div class="about-client">
            <img src="<?= $model->getImageUrl() ?>" alt="product<?=$model->id?>">
<!--            <p class="client-intro">technext-ceo</p>-->
        </div>
        <div class="main-speech">
           <?= $model->text ?>
        </div>
    </div>
</div>

