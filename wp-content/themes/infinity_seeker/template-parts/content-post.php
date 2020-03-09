<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Seeker
 */

?>

<article id="post-<?php the_ID(); ?>" class="container container--page">


    <div class="container--page__visuals">
        <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>

        <?php if( have_rows('image_gallery') ): ?>
            <div class="image-gallery">

                <?php while( have_rows('image_gallery') ): the_row(); 

                    // vars
                    $image = get_sub_field('image'); ?>

                    <a class="venobox" href="<?php echo $image['url']; ?>">
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
                    </a>

                <?php endwhile;?>
            </div>
        <?php endif; ?>
    </div>

    <div class="container--page__copy">
        <h2 class="page-heading"><?php the_title() ?></h2>
        <?php the_content() ?>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->
