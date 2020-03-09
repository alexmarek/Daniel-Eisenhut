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

	<div id="primary" class="content-area">
		<main id="main" class="site-main container">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<a href="/paintings" class="button button--frame center-on-page">
					Paintings &amp; Drawings
				</a>
				<?php
					echo '<h2 class="page-title">' . single_cat_title( '', false ) . '</h2>';
				?>
			</header><!-- .page-header -->

			<div class="latest">
			<?php

			$terms = wp_get_post_terms( $post->ID, 'painting-type'); 
			$terms_ids = [];

			foreach ( $terms as $term ) {
				$terms_ids[] = $term->term_id;
			}

			$args = array(
				'post_type' 	=> 'painting',
				'orderby' 		=> 'title',
				'order'   		=> 'ASC',
				'posts_per_page' 	=> -1,
				'tax_query' 	=> array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'painting-type',
						'field'    => 'term_id',
						'terms'    => $terms_ids
					)
				),
			);
			$query = new WP_Query( $args ); 

			/* Start the Loop */
			while ( $query->have_posts([]) ) :
				$query->the_post();
				get_template_part( 'template-parts/content', 'painting-type' );

			endwhile;

		endif; ?>

		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
