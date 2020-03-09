<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Seeker
 */

?>


<?php

// Get all the categories
wp_reset_postdata();

$args = array(
    'order' => 'DESC' //this is the default as well
);
$taxonomies = get_terms( 'media_file_types', $args );

// Loop through all the returned terms
foreach ( $taxonomies as $taxonomy ):

    // set up a new query for each category, pulling in related posts.
    $types = new WP_Query(
        array(
            'post_type' => 'mediafile',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy'  => 'media_file_types',
                    'terms'     => array( $taxonomy->slug ),
                    'field'     => 'slug'
                    )
                )
            )
        );
    ?>

    <h2 class="button button--frame-larger"><?php echo $taxonomy->name; ?></h2>

    <div class="latest">
        <?php while ($types->have_posts()) : $types->the_post(); ?>
            <div class="latest__item">
                <a href="<?php the_permalink();?>">
                    <div class="latest__item__image">
                        <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'fit-cover  grow transition-25' ) ); ?>
                    </div>
                        
                    <h4 class="u-center-text"><i><?php the_title(); ?></i></h4>
                </a>
            </div>

        <?php endwhile; ?>
    </div>


<?php
    // Reset things, for good measure
    $taxonomies = null;
    wp_reset_postdata();

// end the loop
endforeach;
?>


