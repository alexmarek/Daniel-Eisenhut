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
				<?php
					echo '<h2 class="page-title">' . single_cat_title( '', false ) . '</h2>';
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
