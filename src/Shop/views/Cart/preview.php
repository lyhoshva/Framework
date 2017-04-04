<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Cart $cart
 */
?>
<li>
    <a href="<?= $this->generateRoute('cart_list') ?>">
        Cart <span class="badge btn-success"><?= $cart->getProductsCount() ?></span>
    </a>
</li>
