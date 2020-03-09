<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Infinity_Seeker
 */

get_header();
?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<script src="<?php echo get_template_directory_uri() . '/js/modal.js'; ?>"></script>

<?php

get_footer();