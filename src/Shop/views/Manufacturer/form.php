<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Manufacturer $manufacturer
 */
use Framework\Helper\FormHelper;

?>
<h1><?= $manufacturer->isNewRecord() ? 'Creating manufacturer' : 'Updating manufacturer: ' . $manufacturer->getName() ?></h1>
<ol class="breadcrumb">
    <li><a href="<?= $this->generateRoute('home') ?>">Home</a></li>
    <?php if (!$manufacturer->isNewRecord()) : ?>
        <li><a href="<?= $this->generateRoute('product', ['id' => $manufacturer->getId()]) ?>"><?= $manufacturer->getName() ?></a></li>
    <?php endif; ?>
    <li class="active"><?= $manufacturer->isNewRecord() ? 'Creating manufacturer' : 'Updating manufacturer' ?></li>
</ol>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = FormHelper::begin([
            'class' => 'form-horizontal',
            'method' => 'post',
        ]); ?>

        <div class="form-group <?= !empty($form->getError($manufacturer, 'name')) ? 'has-error has-feedback'  : ''?>">
            <label class="col-sm-1 control-label">Name</label>

            <div class="col-sm-11">
                <?= $form->textInput($manufacturer, 'name', [
                    'class' => 'form-control',
                    'placeholder' => 'Name',
                ]) ?>
                <?php if (!empty($form->getError($manufacturer, 'name'))) : ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($manufacturer, 'name') ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?= $form->submitButton($manufacturer->isNewRecord() ? 'Create' : 'Update', ['class' => 'btn btn-primary pull-right'])?>
        <?php FormHelper::end() ?>
    </div>
</div>
