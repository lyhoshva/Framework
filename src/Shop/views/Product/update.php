<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Product $product
 */
?>
    <ol class="breadcrumb">
        <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
        <li><a href="<?= $this->generateRoute('product', ['id' => $product->getId()]) ?>"><?= $product->getTitle() ?></a></li>
        <li class="active">Updating product</li>
    </ol>
    <h1>Updating product</h1>

<?= $this->render('_form', [
    'product' => $product,
]) ?>