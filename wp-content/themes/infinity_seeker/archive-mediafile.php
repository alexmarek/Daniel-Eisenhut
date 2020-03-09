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
		<main id="main" class="site-main">

			<header class="page-header">
				<h1 class="archive-description">Media</h1>

			</header><!-- .page-header -->

			<?php

			/*
				* Include the Post-Type-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Type name) and that will be used instead.
				*/
			get_template_part( 'template-parts/content', get_post_type() );

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
