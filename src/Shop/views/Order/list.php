<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Order[] $orders
 */
?>
<h1>Order List</h1>
<ol class="breadcrumb">
    <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
    <li class="active">Order list</li>
</ol>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Client Name</th>
        <th>Total Price</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order) : ?>
        <tr>
            <td><?= $order->getClient()->getName() ?></td>
            <td>$ <?= $order->getTotalPrice() ?></td>
            <td><?= $order->getDate()->format('F j, Y H:i:s') ?></td>
            <td><?= !empty($order->getOrderStatus()) ? $order->getOrderStatus()->getName() : null ?></td>
            <td style="width: 5%">
                <a href="<?= $this->generateRoute('order_show', ['id' => $order->getId()]) ?>">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </a>
                <a href="<?= $this->generateRoute('order_update', ['id' => $order->getId()]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
