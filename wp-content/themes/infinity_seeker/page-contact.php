<?php
/**
 * The template for displaying contact page
 *
 * @package Infinity Seeker
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">	

			<?php if ( have_posts() ) : ?>


			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'contact' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
