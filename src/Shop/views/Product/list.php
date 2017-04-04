<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Product[] $products
 * @var \Shop\Model\Manufacturer[] $manufacturers
 */
?>
<?php foreach ($products as $product) : ?>
    <a href="<?= $this->generateRoute('product', ['id' => $product->getId()]); ?>" class="col-sm-4 col-md-3">
        <div class="thumbnail">
            <img src="https://dummyimage.com/480x400/000/0011ff.jpg" class="product_preview__image">
            <div class="caption">
                <h4><?= $product->getTitle() ?></h4>
                Price: $ <?= $product->getPrice() ?>
            </div>
        </div>
    </a>
<?php endforeach; ?>
