<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Order $order
 */

?>
<h1>Order from <?= $order->getClient()->getName() ?></h1>
<ol class="breadcrumb">
    <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
    <li><a href="<?= $this->generateRoute('order_list') ?>">Order list</a></li>
    <li class="active">Order</li>
</ol>
<a href="<?= $this->generateRoute('order_update', ['id' => $order->getId()]) ?>" class="btn btn-primary">Update order</a>
<table class="table table-hover">
    <tbody>
    <?php if(!empty($order->getOrderStatus())) : ?>
        <tr>
            <td>Order status:</td>
            <td><?= $order->getOrderStatus()->getName() ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Client name:</td>
        <td><?= $order->getClient()->getName() ?></td>
    </tr>
    <tr>
        <td>Client Phone:</td>
        <td><?= $order->getClient()->getPhone() ?></td>
    </tr>
    <tr>
        <td>Client Email:</td>
        <td><?= $order->getClient()->getEmail() ?></td>
    </tr>
    <tr>
        <td>Payment Type:</td>
        <td><?= $order->getPaymentType()->getName() ?></td>
    </tr>
    <tr>
        <td>Delivery Type:</td>
        <td><?= $order->getDeliveryType()->getName() ?></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td><?= $order->getAddress() ?></td>
    </tr>
    <tr>
        <td>Total Price:</td>
        <td><?= $order->getTotalPrice() ?></td>
    </tr>
    <tr>
        <td>Date:</td>
        <td><?= $order->getDate()->format('F j, Y H:i:s') ?></td>
    </tr>
    </tbody>
</table>

<h3>Ordered products</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Product name</th>
        <th>Count</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order->getOrderedProducts() as $ordered_product) : ?>
        <tr>
            <td><?= $ordered_product->getProduct()->getTitle() ?></td>
            <td><?= $ordered_product->getCount() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
