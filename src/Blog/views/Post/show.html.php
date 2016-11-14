<?php
/**
 * @var $post \Blog\Model\Post
 */

$date = $post->getDate();
?>

<div class="row">
    <h1><?php echo $post->getTitle() ?></h1>

    <p class="small"><?php echo $date->format('F j, Y H:i:s') ?></p>
    <?php echo htmlspecialchars_decode($post->getContent()) ?>
</div>