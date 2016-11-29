<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\Manufacturer[] $manufacturers
 */
?>
<a href="<?= $this->generateRoute('manufacturers_create') ?>" class="btn btn-primary">Create Manufacturer</a>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($manufacturers as $manufacturer) : ?>
        <tr>
            <td><?= $manufacturer->getId() ?></td>
            <td><?= $manufacturer->getName() ?></td>
            <td style="width: 10%">
                <a href="<?= $this->generateRoute('manufacturers_update', ['id' => $manufacturer->getId()]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="<?= $this->generateRoute('manufacturers_delete', ['id' => $manufacturer->getId()]) ?>"
                   data-confirm="Are you sure want to delete this item?">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
