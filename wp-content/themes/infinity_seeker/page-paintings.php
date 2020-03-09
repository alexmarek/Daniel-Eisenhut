<?php
/**
 * Paintings page
 *
 * @package Infinity_Seeker
 */

get_header();
?>

	<div id="primary" class="content-area container">
        <h2 class="page-title">Paintings &amp; Drawings</h2>
		<main id="main" class="site-main latest">

        

		<div class="paintings latest container">

            <?php 
                // Get all the Painting Types
                $taxonomies = get_terms( 'painting-type' );

                // Loop through all the returned terms
                foreach ( $taxonomies as $taxonomy ):

                    // set up a new query for each category, pulling in related posts.
                    $types = new WP_Query(
                        array(
                            'post_type' => 'painting',
                            'posts_per_page' => 1,
                            'tax_query' => array(
                                array(
                                    'taxonomy'  => 'painting-type',
                                    'terms'     => array( $taxonomy->slug ),
                                    'field'     => 'slug'
                                )
                            )
                        )
                    ); ?>

                    <div class="latest__item">
            
                        <a href="<?php echo '/painting-type/' . $taxonomy->slug;?>" class="latest__image">
                            <?php 
                                if (function_exists('get_wp_term_image'))
                                {
                                    $meta_image = get_wp_term_image($taxonomy->term_id); 
                                }
                                
                                echo '<img src="' . $meta_image . '" alt="'. $taxonomy->name . '" />';
                                
                            ?>
                        </a>
                        
                        <a href="<?php echo '/painting-type/' . $taxonomy->slug;?>">
                            <button class="button button--frame-larger">
                                <?php echo $taxonomy->name; ?>
                            </button>
                        </a>
                        <div class="latest__item__description">
                            <p><?php echo $taxonomy->description; ?></p>
                            <a href="<?php echo '/painting-type/' . $taxonomy->slug;?>">
                                <button class="button button--text">
                                    Explore
                                </button>
                            </a>
                        </div>                        
                </div>
            
                <?php
                    // Reset things, for good measure
                    $services = null;
                    wp_reset_postdata();

                // end the loop
                endforeach;
                ?>

        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();



