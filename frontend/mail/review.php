<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\Contact
 */
?>
<?= $this->render('layouts/header')  ?>

<div style="box-sizing: border-box; margin: 0; padding: 0 0 20px;">
<div style="box-sizing: border-box; width: 600px; font-family: 'Arial', sans-serif; font-size: 14px; color: #010101; margin: 0 auto; padding: 0;">
<div style="box-sizing: border-box; font-family: 'Arial', sans-serif; font-size: 27px; line-height: 32px; font-weight: normal; text-align: center; margin: 0 0 30px; padding: 30px 0 0;" align="center"><?= Yii::t('mail', 'Review') ?></div>
    <br style="box-sizing: border-box; margin: 0; padding: 0;">
    <br style="box-sizing: border-box; margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" style="box-sizing: border-box; width: 600px; font-family: 'Arial', sans-serif; font-size: 14px; color: #010101; border-collapse: collapse; margin: 0 auto; padding: 0;">
        <tr style="box-sizing: border-box; margin: 0; padding: 0;">
            <td style="box-sizing: border-box; vertical-align: top; text-align: left; width: 50%; margin: 0; padding: 0;" align="left" valign="top">
                <ul style="box-sizing: border-box; font-size: 13px; line-height: 20px; margin: 0; padding: 0;">
                    <li style="box-sizing: border-box; margin: 0 0 17px; padding: 0; list-style: none;">
                        <span style="box-sizing: border-box; color: #807e7e; margin: 0; padding: 0;"><?= Yii::t('mail','Name') ?>:</span>
                        <br style="box-sizing: border-box; margin: 0; padding: 0;"><span style="box-sizing: border-box; margin: 0; padding: 0;"><?= $model->name ?></span>
                    </li>
                </ul>
            </td>
            <td style="box-sizing: border-box; vertical-align: top; text-align: left; width: 50%; margin: 0; padding: 0;" align="left" valign="top">
                <ul style="box-sizing: border-box; font-size: 13px; line-height: 20px; margin: 0; padding: 0;">
                    <li style="box-sizing: border-box; margin: 0 0 17px; padding: 0; list-style: none;">
                        <span style="box-sizing: border-box; color: #807e7e; margin: 0; padding: 0;"><?= Yii::t('mail','Message') ?>:</span>
                        <br style="box-sizing: border-box; margin: 0; padding: 0;"><span style="box-sizing: border-box; margin: 0; padding: 0;"><?= $model->message ?></span>
                    </li>
                </ul>
            </td>
        </tr>
    </table>
</div>
</div>

<?= $this->render('layouts/footer')  ?>