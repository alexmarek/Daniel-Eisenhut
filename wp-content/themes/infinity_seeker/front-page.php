<?php
/**
 * The template for displaying the home page
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

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'home' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<script src="<?php echo get_template_directory_uri() . '/js/slider.js'; ?>"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {

			let scrollPos = 0;
			const nav = document.querySelector('.site-header');

			function checkPosition() {
			let windowY = window.scrollY;
			if (windowY > 200) {
				nav.classList.add('is-scrolled');
			} 
			scrollPos = windowY;
			}

			function debounce(func, wait = 10, immediate = true) {
				let timeout;
				return function() {
					let context = this, args = arguments;
					let later = function() {
					timeout = null;
					if (!immediate) func.apply(context, args);
					};
					let callNow = immediate && !timeout;
					clearTimeout(timeout);
					timeout = setTimeout(later, wait);
					if (callNow) func.apply(context, args);
				};
			};

			window.addEventListener('scroll', debounce(checkPosition));
		});


	</script>
	
<?php
get_footer();


