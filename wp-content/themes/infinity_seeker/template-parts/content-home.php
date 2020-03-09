<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Seeker
 */

?>

<article <?php post_class(); ?>>

<?php if( have_rows('slider_content') ): ?>

    <div class="slider siema">

        <?php while( have_rows('slider_content') ): the_row(); 

            // vars
            $image = get_sub_field('slider_image');
            $title = get_sub_field('slider_title');
            $buttonLink = get_sub_field('slider_button_link');
            $buttonText = get_sub_field('slider_button_text');

            ?>

            <div class="slide">
                <div class="slide__image">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
                </div>

                <div class="slide__text button--frame-mid">
                    <h2><?php echo $title; ?></h2>
                    <?php if( $buttonLink ): ?>
                        <a href="<?php echo $buttonLink; ?>"><button class="button button--text"><?php echo $buttonText; ?></button></a>
                    <?php endif; ?>
                </div>
            </div>

        <?php endwhile; ?>

    </div>
    
    <div class="slider__controls">
        <button class="prev"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="26"><path d="M33 13H.8M12.86 1L.8 13l12.06 12" fill="none" fill-rule="evenodd" stroke="#000" stroke-linejoin="round"/></svg></button>
        <button class="next"><svg xmlns="http://www.w3.org/2000/svg" width="33" height="26"><path d="M33 13H.8M12.86 1L.8 13l12.06 12" fill="none" fill-rule="evenodd" stroke="#000" stroke-linejoin="round"/></svg></button> 
    </div>
    

<?php endif; ?>


<h2>News, what I am up to</h2>

<div class="news latest container">
    <?php
        // the query
        $the_query = new WP_Query(array(
            'category_name' => 'homepage',
            'post_status' => 'publish',
            'posts_per_page' => 3,
        ));
        ?>

        <?php if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="latest__item">
                    <a href="<?php the_permalink();?>" class="latest__image">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
                        <button class="button button--frame">
                            Explore
                        </button>
                    </a>
                </div>
                
                

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            
    <?php endif; ?>
</div>

<div class="about-me container">
    <div class="about-me--content">
        <?php the_content();?>
    </div>
</div>


<h2>Paintings & Drawings</h2>

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
                <a href="<?php echo '/painting-type/' . $taxonomy->slug;?>" title="<?php echo $taxonomy->name; ?>">
                    <button class="button button--frame-larger">
                        <?php echo $taxonomy->name; ?>
                    </button>
                </a>
        </div>
       
        <?php
            // Reset things, for good measure
            $services = null;
            wp_reset_postdata();

        // end the loop
        endforeach;
        ?>

</div>

<div class="get-in-touch container">
    <div class="get-in-touch__contact">
        <h2>Contact</h2>
        <?php echo do_shortcode('[contact-form-7 id="4013" title="Contact"]'); ?>
    </div>
    <div class="get-in-touch__instagram">
    <h2>Instagram</h2>
        <?php echo do_shortcode('[instagram-feed]'); ?>
    </div>
</div>


	
</article><!-- #post-<?php the_ID(); ?> -->