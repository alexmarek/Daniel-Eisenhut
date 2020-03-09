<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Seeker
 */

get_header();
?>

	<div id="primary" class="content-area container">
        <h2 class="page-title">Events</h2>
		<main id="main" class="site-main latest">

        

		<?php 
            // the query
            $query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'category_name' => 'Events', 'posts_per_page'=>-1)); ?>
            
            <?php if ( $query->have_posts() ) : ?>
        
                <!-- the loop -->
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="latest__item">
                        <a href="<?php the_permalink();?>" class="latest__image">
                            <?php the_post_thumbnail(); ?>
                        </a>
                        <h3><?php the_title(); ?></h3>
                        <h4><i><?php the_field('event_date');?></i></h4>
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink();?>">
                            <button class="button button--text button--text-archive">
                                Read
                            </button>
                        </a>
                    </div>
                <?php endwhile; ?>
                <!-- end of the loop -->
            
                <?php wp_reset_postdata(); ?>
            
            <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
