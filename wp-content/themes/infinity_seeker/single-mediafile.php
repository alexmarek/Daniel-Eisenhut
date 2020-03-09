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
		<main id="main" class="site-main u-margin-bottom-big">

		<?php
		while ( have_posts() ) :
			the_post();
			echo '<h2 class="u-margin-bottom-big">' . get_the_title() . '</h2>';
			the_content();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();