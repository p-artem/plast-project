<?php
/**
 * @var $this \yii\web\View
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html lang="en" style="box-sizing: border-box; margin: 0; padding: 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title><?= Yii::t('mail', 'Plast-Tara E-mail') ?></title>
</head>

<body style="box-sizing: border-box; margin: 0; padding: 0;">
<div style="box-sizing: border-box; width: 100%; min-width: 650px; margin: 0 auto; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" style="box-sizing: border-box; width: 600px; font-family: 'Arial', sans-serif; font-size: 14px; color: #010101; border-collapse: collapse; border-bottom-width: 1px; border-bottom-color: #d7d7d7; border-bottom-style: solid; margin: 0 auto 15px; padding: 0;">
    <tr style="box-sizing: border-box; margin: 0; padding: 0;">
        <td style="box-sizing: border-box; vertical-align: middle; text-align: left; margin: 0; padding: 20px 0;" align="left" valign="middle">
            <a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/']) ?>" style="box-sizing: border-box; color: #0073d2; text-decoration: none; display: block; width: 190px; margin: 0; padding: 0;">
                <img src="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/img/main_logo.png']) ?>" alt="<?= Yii::$app->name ?>" style="box-sizing: border-box; display: block; width: 100%; margin: 0; padding: 0;">
            </a>
        </td>
        <td style="box-sizing: border-box; vertical-align: middle; text-align: right; margin: 0; padding: 20px 0;" align="right" valign="middle">
            <ul style="box-sizing: border-box; font-size: 12px; line-height: 21px; margin: 0; padding: 0;">
                <li style="box-sizing: border-box; margin: 0; padding: 0; list-style: none;"><?= Yii::$app->keyStorage->get('shop_phones') ?></li>
            </ul>
        </td>
    </tr>
</table>