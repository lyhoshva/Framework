<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Order $order
 * @var \Shop\Model\DeliveryType[] $deliveryTypes
 * @var \Shop\Model\PaymentType[] $paymentTypes
 * @var \Shop\Model\OrderStatus[] $orderStatuses
 */

use Framework\Helper\ArrayHelper;
use Framework\Helper\FormHelper;

?>
<h1><?= $order->isNewRecord() ? 'Creating order' : 'Updating order' ?></h1>
<ol class="breadcrumb">
    <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
    <?php if (!$order->isNewRecord()) : ?>
        <li><a href="<?= $this->generateRoute('order_list') ?>">Order list</a></li>
        <li><a href="<?= $this->generateRoute('order_show', ['id' => $order->getId()]) ?>">Order</a></li>
    <?php endif; ?>
    <li class="active"><?= $order->isNewRecord() ? 'Creating order' : 'Updating order' ?></li>
</ol>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = FormHelper::begin([
            'class' => 'form-horizontal',
            'method' => 'post',
        ]); ?>

        <div class="form-group <?= !empty($form->getError($order, 'address')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Address</label>

            <div class="col-sm-11">
                <?= $form->textInput($order, 'address', [
                    'class' => 'form-control',
                    'placeholder' => 'Address',
                ]) ?>
                <?php if (!empty($form->getError($order, 'address'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($order, 'address') ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group <?= !empty($form->getError($order, 'deliveryType')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Delivery Type</label>

            <div class="col-sm-11">
                <?= $form->dropDown(
                    'deliveryType',
                    !empty($order->getDeliveryType()) ? $order->getDeliveryType()->getId() : null,
                    ArrayHelper::map($deliveryTypes, 'id', 'name'),
                    'Choose delivery type',
                    [
                        'class' => 'form-control',
                    ]
                ) ?>
                <?php if (!empty($form->getError($order, 'deliveryType'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($order, 'deliveryType') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($order, 'paymentType')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Payment Type</label>

            <div class="col-sm-11">
                <?= $form->dropDown(
                    'paymentType',
                    !empty($order->getPaymentType()) ? $order->getPaymentType()->getId() : null,
                    ArrayHelper::map($paymentTypes, 'id', 'name'),
                    'Choose payment type',
                    [
                        'class' => 'form-control',
                    ]
                ) ?>
                <?php if (!empty($form->getError($order, 'paymentType'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($order, 'paymentType') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!$order->isNewRecord()) : ?>
            <div class="form-group <?= !empty($form->getError($order, 'orderStatus')) ? 'has-error has-feedback'  : ''?>">
                <label class="col-sm-1 control-label">Order Status</label>

                <div class="col-sm-11">
                    <?= $form->dropDown(
                        'orderStatus',
                        !empty($order->getOrderStatus()) ? $order->getOrderStatus()->getId() : null,
                        ArrayHelper::map($orderStatuses, 'id', 'name'),
                        'Choose order status',
                        [
                            'class' => 'form-control',
                        ]
                    ) ?>
                    <?php if (!empty($form->getError($order, 'orderStatus'))) : ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span class="pull-right small form-error"><?= $form->getError($order, 'orderStatus') ?></span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $form->submitButton($order->isNewRecord() ? 'Create' : 'Update', ['class' => 'btn btn-primary pull-right'])?>

        <?php FormHelper::end() ?>

    </div>
</div>
