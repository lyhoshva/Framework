<?php
/**
 * @var $this \Framework\Renderer\Renderer
 * @var $cart \Shop\Model\Cart
 * @var $products \Shop\Model\Product[]
 */
$cart_array = $cart->getCartArray();
?>
<h1>Cart list</h1>
<a href="<?= $this->generateRoute('clear_cart') ?>" class="btn btn-primary">Clear cart</a>
<table class="table table-hover">
    <tbody>
    <?php foreach ($products as $product) : ?>
        <tr class="row" data-cart-item-link="<?= $this->generateRoute('cart_set_count', ['id' => $product->getId(), 'count' => '']) ?>">
            <td class="col-md-7"><?= $product->getTitle() ?></td>
            <td class="col-md-2">
                <span class="glyphicon glyphicon-minus" data-cart="dec"></span>
                <input type="text" value="<?= $cart->getProductCount($product) ?>" data-cart="input" style="width: 50px">
                <span class="glyphicon glyphicon-plus" data-cart="inc"></span>
            </td>
            <td class="col-md-2">
                $ <span data-cart="product-price"><?= $cart->getProductPrice($product) ?></span>
            </td>
            <td class="col-md-1">
                <a href="<?= $this->generateRoute('cart_delete', ['id' => $product->getId()]) ?>"
                   data-confirm="Are you sure want to delete the item?">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr class="row">
        <td colspan="4" class="col-md-12">
            <span class="pull-right">
                Total: $ <span data-cart="total-price"><?= $cart->getTotalPrice() ?></span>
            </span>
        </td>
    </tr>
    </tbody>
</table>

