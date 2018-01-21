<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\SiteBreadcrumbs;
use common\models\Order;

/* @var $this yii\web\View */
/* @var $order \common\models\Order */
/* @var $form yii\widgets\ActiveForm */

$this->context->layout = '@frontend/views/layouts/main.php';

$this->title = Yii::t('user', 'Order status');
?>
<div class="container">
    <?= SiteBreadcrumbs::widget([
        'links' => [
            ['url' => Url::to(['user/profile'],true),'label' => Yii::t('user', 'User Profile')],
            'label' => $this->title]
        ]
    ) ?>
    <div class="order-details-wrap">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>

        <ul class="order-status">
            <li class="step<?= $order->status >= Order::STATUS_PROCESS ? ' made' : '' ?>">
                <span>1</span>
                <span class="step-descr"><?= Order::getStatus(Order::STATUS_PROCESS) ?></span>
            </li>
            <?php if ($order->status == Order::STATUS_CANCELED): ?>
                <li class="step cancel">
                    <span>2</span>
                    <span class="step-descr"><?= Order::getStatus(Order::STATUS_CANCELED) ?></span>
                </li>
            <?php else: ?>
                <li class="step<?= $order->status >= Order::STATUS_PAYMENT ? ' made' : '' ?>">
                    <span>2</span>
                    <span class="step-descr"><?= Order::getStatus(max(min(Order::STATUS_SHIPMENT, $order->status),Order::STATUS_PAYMENT)) ?></span>
                </li>
            <?php endif; ?>
            <li class="step<?= $order->status >= Order::STATUS_SEND ? ' made' : '' ?>">
                <span>3</span>
                <span class="step-descr"><?= Order::getStatus(Order::STATUS_SEND) ?></span>
            </li>
            <?php if ($order->status == Order::STATUS_RETURN): ?>
                <li class="step cancel">
                    <span>4</span>
                    <span class="step-descr"><?= Order::getStatus(Order::STATUS_RETURN) ?></span>
                </li>
            <?php else: ?>
                <li class="step<?= $order->status >= Order::STATUS_DELIVERED ? ' made' : '' ?>">
                    <span>4</span>
                    <span class="step-descr"><?= Order::getStatus(Order::STATUS_DELIVERED) ?></span>
                </li>
            <?php endif; ?>
            <li class="step<?= $order->status == Order::STATUS_RECIEVED ? ' made' : '' ?>">
                <span>5</span>
                <span class="step-descr"><?= Order::getStatus(Order::STATUS_RECIEVED) ?></span>
            </li>
        </ul>

        <div class="content-title">
            <h3><?= Yii::t('site', 'Cash-memo') ?></h3>
        </div>

        <div class="order-details">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li>
                            <span><?= $order->getAttributeLabel('id') ?>:</span>
                            <p><?= $order->id ?></p>
                        </li>
                        <li>
                            <span><?= $order->getAttributeLabel('created_at') ?>:</span>
                            <p><?= Yii::$app->formatter->asDate($order->created_at) ?></p>
                        </li>
                        <?php if ($order->payment_method): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('payment_method') ?>:</span>
                            <p><?= $order->payment_method ?></p>
                        </li>
                        <?php endif; ?>
                        <?php if ($order->delivery): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('delivery') ?>:</span>
                            <p><?= $order->delivery ?></p>
                        </li>
                        <?php endif; ?>
                        <?php if ($order->destination): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('destination') ?>:</span>
                            <p><?= $order->destination ?></p>
                        </li>
                        <?php endif; ?>
                        <?php if ($order->declaration): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('declaration') ?>:</span>
                            <p><?= $order->declaration ?></p>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <?php if ($order->recipient): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('recipient') ?>:</span>
                            <p><?= $order->recipient ?></p>
                        </li>
                        <?php endif; ?>
                        <?php if ($order->recipient_phone): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('recipient_phone') ?>:</span>
                            <p><?= $order->recipient_phone ?></p>
                        </li>
                        <?php endif; ?>
                        <?php if ($order->text): ?>
                        <li>
                            <span><?= $order->getAttributeLabel('text') ?>:</span>
                            <p>
                                <?= $order->text ?>
                            </p>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div><!-- order-details END -->

        <div class="basket-list">

            <?php $count = 1;
                foreach ($order->orderProducts as $orderProduct):
                    $product = $orderProduct->product; ?>
            <div class="wish-prod-item">
                <div class="row">
                    <div class="col-sm-4 col-md-2">
                        <a href="<?= Url::to(['/product/view', 'slug' => $product->slug]) ?>" class="prod-photo">
                            <img src="<?= $product->imageUrl ?>" alt="<?= $product->name ?>">
                        </a>
                    </div>

                    <div class="col-sm-8 col-md-10">

                        <div class="prod-top-info">
                            <a href="<?= Url::to(['/product/view', 'slug' => $product->slug]) ?>" class="prod-name"><?= $product->name ?></a>
                            <span class="part-n"><?= Yii::t('site', 'Part NO.') ?>: <?= $product->part_numb ?></span>
                        </div>

                        <table class="order-info hidden-xs hidden-sm">
                            <thead>
                            <tr>
                                <td>№</td>
                                <td><?= Yii::t('site', 'Price') ?></td>
                                <td><?= Yii::t('site', 'Warranty service') ?></td>
                                <td><?= Yii::t('site', 'Quantity') ?></td>
                                <td><?= Yii::t('site', 'Total amount') ?></td>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <span class="prod-number"><?= $count ?></span>
                                </td>
                                <td>
                                    <span class="price"><?= number_format($orderProduct->price, 0, '.', '&nbsp;') ?> <?= Yii::t('site', 'UAH') ?></span>
                                </td>
                                <td>
                                    <span class="warranty">
                                    <?= $orderProduct->service ?
                                        $orderProduct->service->name :
                                        Yii::t('site', 'Warranty is empty') ?>
                                    </span>
                                </td>
                                <td>
                                    <span><?= $orderProduct->quantity ?></span>
                                </td>
                                <td>
                                    <span class="total-price">
                                        <?= number_format($orderProduct->price * $orderProduct->quantity, 0, '.', '&nbsp;') ?> <?= Yii::t('site', 'UAH') ?>
                                    </span>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <table class="order-info-mobile hidden-md hidden-lg">
                            <tbody><tr>
                                <td>№</td>
                                <td>
                                    <span class="prod-number"><?= $count ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Yii::t('site', 'Price') ?></td>
                                <td>
                                    <span class="price"><?= number_format($orderProduct->price, 0, '.', '&nbsp;') ?> <?= Yii::t('site', 'UAH') ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Yii::t('site', 'Warranty service') ?></td>
                                <td>
                                    <span class="warranty">
                                    <?= $orderProduct->service ?
                                        $orderProduct->service->name :
                                        Yii::t('site', 'Warranty is empty') ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Yii::t('site', 'Quantity') ?></td>
                                <td>
                                    <span><?= $orderProduct->quantity ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Yii::t('site', 'Total amount') ?></td>
                                <td>
                                    <span class="total-price"><?= number_format($orderProduct->price * $orderProduct->quantity, 0, '.', '&nbsp;') ?> <?= Yii::t('site', 'UAH') ?></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php $count++; endforeach; ?>

            <div class="order-amount-wrap">
<!--                <div class="order-amount-row">-->
<!--                    <span class="order-amount">Сумма бонусов:</span>-->
<!--                    <span>10324958</span>-->
<!--                </div>-->
                <div class="order-amount-row">
                    <span class="order-amount">Сумма заказа:</span>
                    <span><?= number_format($order->sum, 0, '.', '&nbsp;') ?> <?= Yii::t('site', 'UAH') ?></span>
                </div>
            </div>


            <div class="button-wrap">
                <a href="<?= Url::to(['/user']) ?>" class="btn btn-primary"><?= Yii::t('site', 'Back to your personal cabinet') ?></a>
            </div>
        </div>
    </div>
</div>