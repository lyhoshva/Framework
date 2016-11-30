<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var \Shop\Model\User $user
 */
use Framework\Helper\FormHelper;

?>
<div class="container">
    <?php $form = FormHelper::begin([
        'class' => 'form-signup',
        'method' => 'post',
        'action' => $this->generateRoute('signup'),
    ]) ?>
    <h2 class="form-signup-heading">Please sign up</h2>
    <div class="form-group <?= !empty($form->getError($user, 'name')) ? 'has-error has-feedback'  : ''?>">
        <label class="control-label">Name</label>
        <?= $form->textInput($user, 'name', [
            'class' => 'form-control',
            'placeholder' => 'Name',
        ]) ?>
        <?php if (!empty($form->getError($user, 'name'))) : ?>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span class="pull-right small form-error"><?= $form->getError($user, 'name') ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group <?= !empty($form->getError($user, 'email')) ? 'has-error has-feedback'  : ''?>">
        <label class="control-label">E-mail</label>

        <?= $form->textInput($user, 'email', [
            'class' => 'form-control',
            'placeholder' => 'E-mail',
        ]) ?>
        <?php if (!empty($form->getError($user, 'email'))) : ?>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span class="pull-right small form-error"><?= $form->getError($user, 'email') ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group <?= !empty($form->getError($user, 'phone')) ? 'has-error has-feedback'  : ''?>">
        <label class="control-label">Phone</label>
        <?= $form->textInput($user, 'phone', [
            'class' => 'form-control',
            'placeholder' => 'Phone',
        ]) ?>
        <?php if (!empty($form->getError($user, 'phone'))) : ?>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span class="pull-right small form-error"><?= $form->getError($user, 'phone') ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group <?= !empty($form->getError($user, 'password')) ? 'has-error has-feedback'  : ''?>">
        <label class="control-label">Password</label>
        <?= $form->passwordInput($user, 'password', [
            'class' => 'form-control',
            'placeholder' => 'Password',
        ]) ?>
        <?php if (!empty($form->getError($user, 'password'))) : ?>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span class="pull-right small form-error"><?= $form->getError($user, 'password') ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group <?= !empty($form->getError($user, 'rePassword')) ? 'has-error has-feedback'  : ''?>">
        <label class="control-label">Password confirm</label>
        <?= $form->passwordInput($user, 'rePassword', [
            'class' => 'form-control',
            'placeholder' => 'Password confirm',
        ]) ?>
        <?php if (!empty($form->getError($user, 'rePassword'))) : ?>
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <span class="pull-right small form-error"><?= $form->getError($user, 'rePassword') ?></span>
        <?php endif; ?>
    </div>

    <?= $form->submitButton('Sign up', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
    <?php FormHelper::end(); ?>
</div>
