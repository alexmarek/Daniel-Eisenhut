<div class="latest__item">
    <a href="<?php the_permalink();?>">
        <div class="grow transition-25">
            <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
        </div>
            
        <h3><?php the_title(); ?></h3>
    </a>
</div>