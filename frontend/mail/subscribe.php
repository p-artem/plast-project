<?php
/**
 * @var $this \yii\web\View
 * @var $siteName string
 */
?>
<?= $this->render('layouts/header')  ?>
<div style="box-sizing: border-box; margin: 0; padding: 0 0 20px;">
    <div style="box-sizing: border-box; width: 600px; font-family: 'Arial', sans-serif; font-size: 14px; color: #010101; margin: 0 auto; padding: 0;">
        <div style="box-sizing: border-box; font-family: 'Arial', sans-serif; font-size: 27px; line-height: 32px; font-weight: normal; text-align: center; margin: 0 0 30px; padding: 30px 0 0;" align="center">Подписка на рассылку</div>
        <div style="box-sizing: border-box; margin: 0 auto; padding: 0;">
            <p style="box-sizing: border-box; line-height: 20px; margin: 0 0 20px; padding: 0;">
                <?= Yii::t('site', 'You have been subscribed on {siteName}.', ['siteName' => $siteName]) ?>
            </p>
        </div>
    </div>
</div>
<?= $this->render('layouts/footer')  ?>
