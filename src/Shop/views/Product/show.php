<?php
/**
 * @var \Shop\Model\Product $product
 * @var \Framework\Renderer\Renderer $this
 */
use Framework\DI\Service;
use Shop\Model\Roles;

?>
<div class="col-md-12">
    <h1><?= $product->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
        <li class="active"><?= $product->getTitle()?></li>
    </ol>
    <?php if (Service::get('security')->checkPermission([Roles::ROLE_ADMIN])) : ?>
    <a href="<?= $this->generateRoute('update_product', ['id' => $product->getId()]) ?>" class="btn btn-primary">Update</a>
    <a href="<?= $this->generateRoute('delete_product', ['id' => $product->getId()]) ?>" class="btn btn-danger"
       data-confirm="Are you sure want to delete the item?">Delete</a>
    <?php endif; ?>
</div>
<div class="col-md-5">
    <img src="https://dummyimage.com/480x400/000/0011ff.jpg" class="thumbnail product__image">
</div>
<div class="col-md-7">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Свойство</th>
            <th>Значение</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Дисплей</td>
            <td><?= $product->getDisplay() ?>″</td>
        </tr>
        <tr>
            <td>Камера</td>
            <td><?= $product->getCamera() ?> Mpx</td>
        </tr>
        <tr>
            <td>Память</td>
            <td><?= $product->getMemory() ?> Mb</td>
        </tr>
        <tr>
            <td>Процессор</td>
            <td><?= $product->getProcessor() ?></td>
        </tr>
        <tr>
            <td>Количество SIM</td>
            <td><?= $product->getSimCount() ?> шт.</td>
        </tr>
        <tr>
            <td>Производитель</td>
            <td><?= $product->getManufacturer()->getName() ?></td>
        </tr>
        <tr>
            <td>Цена</td>
            <td>$ <?= $product->getPrice() ?></td>
        </tr>
        </tbody>
    </table>
    <a href="<?= $this->generateRoute('add_to_cart', ['id' => $product->getId()]) ?>"
       class="btn btn-success pull-right" data-method="POST">Add to cart</a>
</div>
