<?php
/**
 * @var $this \yii\web\View
 */
use common\models\Page;
use common\models\PageMenu;
?>
<div style="box-sizing: border-box; border-top-width: 1px; border-top-color: #efefef; border-top-style: solid; background: #f8f8f8; margin: 0; padding: 20px 0;">
<table border="0" cellpadding="0" cellspacing="0" style="box-sizing: border-box; width: 600px; font-family: 'Arial', sans-serif; font-size: 14px; color: #010101; border-collapse: collapse; margin: 0 auto; padding: 0;">
<tr style="box-sizing: border-box; font-size: 12px; line-height: 23px; margin: 0; padding: 0;">
    <td style="box-sizing: border-box; vertical-align: top; width: 33.3%; margin: 0; padding: 0 0 10px;" valign="top">
        <div style="box-sizing: border-box; margin: 0; padding: 0;">
            <ul style="box-sizing: border-box; margin: 0; padding: 0;">
                <?php $items = Page::find()->byMenuId(PageMenu::MENU_TOP)->getAllAsTree(); ?>
                <?php foreach ($items as $item): ?>
                    <li style="box-sizing: border-box; margin: 0; padding: 0; list-style: none;">
                        <a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/category/view', 'slug'=>$item['slug']])?>" style="box-sizing: border-box; color: #626364; text-decoration: none; margin: 0; padding: 0;"><?= $item['name'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </td>
</tr>
<tr style="box-sizing: border-box; margin: 0; padding: 0;">
    <td colspan="3" style="box-sizing: border-box; vertical-align: top; margin: 0; padding: 0;" valign="top">
        <div style="box-sizing: border-box; text-align: center; margin: 0; padding: 0 0 25px;" align="center">
            <ul style="box-sizing: border-box; margin: 0; padding: 0;">
                <li style="box-sizing: border-box; margin: 0; padding: 0; list-style: none;">
                    <?= Yii::t('site', 'Office Address') ?>
                </li>
                <li style="box-sizing: border-box; margin: 0; padding: 0; list-style: none;">
                    <?= Yii::$app->keyStorage->get('shop_address') ?>
                </li>
            </ul>
        </div>
    </td>
</tr>

<tr style="box-sizing: border-box; text-align: center; margin: 0; padding: 0;" align="center">
    <td colspan="3" style="box-sizing: border-box; vertical-align: top; margin: 0; padding: 0;" valign="top">
        <div style="box-sizing: border-box; font-size: 11px; line-height: 18px; color: #909090; margin: 0; padding: 0;">
            © <?= Yii::$app->name ?> 2017–<?= date('Y') ?>
        </div>
    </td>
</tr>
</table>
</div>
</div>
</body>
</html>