<?php
/**
 * @var $post \Blog\Model\Post
 */
use Framework\Helper\FormHelper;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php if ($post->isNewRecord()) {
                echo 'Add New Post';
            } else {
                echo 'Edit Post';
            } ?></h3>
    </div>
    <div class="panel-body">

        <?php if (isset($error) && !is_array($error)) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php } ?>


        <?php $form = FormHelper::begin([
            'class' => 'form-horizontal',
            'role' => 'form',
            'method' => 'post',
            'id' => 'post-form',
            'action' => $action,
        ]) ?>
            <div class="form-group <?= !empty($form->getError($post, 'title')) ? 'has-error has-feedback'  : ''?>">
                <label class="col-sm-2 control-label">Title</label>

                <div class="col-sm-10">
                    <?= $form->textInput($post, 'title', [
                        'class' => 'form-control',
                        'placeholder' => 'Title',
                    ]) ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="pull-right small form-error"><?= $form->getError($post, 'title') ?></span>
                </div>
            </div>
            <div class="form-group <?= !empty($form->getError($post, 'content')) ? 'has-error has-feedback'  : ''?>">
                <label class="col-sm-2 control-label">Content</label>

                <div class="col-sm-10">


                    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b
                                    class="caret"></b></a>
                            <ul class="dropdown-menu">
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                                    class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i
                                    class="icon-align-right"></i></a>
                            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>

                            <div class="dropdown-menu input-append">
                                <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                                <button class="btn" type="button">Add</button>
                            </div>
                            <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                        </div>


                        <div class="btn-group">
                            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                    </div>

                    <div id="editor">
                        <?php echo htmlspecialchars_decode($post->getContent()) ?>
                    </div>

                    <input type="hidden" name="content" id="post-content" value="">
                    <?= $form->getError($post, 'content') ?>
                </div>
            </div>

            <div class="btn-group pull-right">
                <?= $form->submitButton('Save', [
                    'class' => 'btn btn-success mr-5',
                ]) ?>
                <a href="/" class="btn btn-danger">Cancel</a>
            </div>
        <?php FormHelper::end() ?>
    </div>
</div>