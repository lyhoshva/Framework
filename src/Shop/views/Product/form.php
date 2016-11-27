<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Product $product
 * @var \Shop\Model\Manufacturer[] $manufacturers
 */
use Framework\Helper\ArrayHelper;
use Framework\Helper\FormHelper;

?>
<h1><?= $product->isNewRecord() ? 'Creating product' : 'Updating product: ' . $product->getTitle() ?></h1>
<ol class="breadcrumb">
    <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
    <?php if (!$product->isNewRecord()) : ?>
        <li><a href="<?= $this->generateRoute('product', ['id' => $product->getId()]) ?>"><?= $product->getTitle() ?></a></li>
    <?php endif; ?>
    <li class="active"><?= $product->isNewRecord() ? 'Creating product' : 'Updating product' ?></li>
</ol>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = FormHelper::begin([
            'class' => 'form-horizontal',
            'method' => 'post',
        ]); ?>

        <div class="form-group <?= !empty($form->getError($product, 'title')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Title</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'title', [
                    'class' => 'form-control',
                    'placeholder' => 'Title',
                ]) ?>
                <?php if (!empty($form->getError($product, 'title'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'title') ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group <?= !empty($form->getError($product, 'manufacturer')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Manufacturer</label>

            <div class="col-sm-11">
                <?= $form->dropDown(
                    'manufacturer',
                    !empty($product->getManufacturer()) ? $product->getManufacturer()->getId() : null,
                    ArrayHelper::map($manufacturers, 'id', 'name'),
                    'Choose manufacturer',
                    [
                        'class' => 'form-control',
                    ]
                ) ?>
                <?php if (!empty($form->getError($product, 'manufacturer'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'manufacturer') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'display')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Display</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'display', [
                    'class' => 'form-control',
                    'placeholder' => 'Display, "',
                ]) ?>
                <?php if (!empty($form->getError($product, 'display'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'display') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'memory')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Memory</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'memory', [
                    'class' => 'form-control',
                    'placeholder' => 'Memory, Mb',
                ]) ?>
                <?php if (!empty($form->getError($product, 'memory'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'memory') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'processor')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Processor</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'processor', [
                    'class' => 'form-control',
                    'placeholder' => 'Processor',
                ]) ?>
                <?php if (!empty($form->getError($product, 'processor'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'processor') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'camera')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Camera</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'camera', [
                    'class' => 'form-control',
                    'placeholder' => 'Camera, Mp',
                ]) ?>
                <?php if (!empty($form->getError($product, 'camera'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'camera') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'simCount')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Sim count</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'simCount', [
                    'class' => 'form-control',
                    'placeholder' => 'Sim count',
                ]) ?>
                <?php if (!empty($form->getError($product, 'simCount'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'simCount') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?= !empty($form->getError($product, 'price')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Price</label>

            <div class="col-sm-11">
                <?= $form->textInput($product, 'price', [
                    'class' => 'form-control',
                    'placeholder' => 'Price, $',
                ]) ?>
                <?php if (!empty($form->getError($product, 'price'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($product, 'price') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?= $form->submitButton($product->isNewRecord() ? 'Create' : 'Update', ['class' => 'btn btn-primary pull-right'])?>

        <?php FormHelper::end() ?>

    </div>
</div>

