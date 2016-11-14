<?php
/**
 * @var $posts \Blog\Model\Post
 * @var $post \Blog\Model\Post
 */
?>

<div class="col-sm-8 blog-main">
    <?php foreach ($posts as $post) { ?>

        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/<?php echo $post->getId() ?>"> <?php echo $post->getTitle() ?></a></h2>

            <p class="blog-post-meta"><?php echo $post->getDate()->format('F j, Y H:i:s') ?> by <a
                    href="#"></a>
            </p>

            <?php echo htmlspecialchars_decode($post->getContent()) ?>
        </div>

    <?php } ?>

    <div>
        <?php $this->executeAction('Blog\\Controller\\PostController', 'getPost', array('id' => 'TestId')) ?>
    </div>

</div>

