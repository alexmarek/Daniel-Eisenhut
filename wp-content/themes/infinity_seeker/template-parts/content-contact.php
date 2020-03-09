<?php
/**
 * Template part for displaying page content in page-speakers-attendees.php
 *
 * @package Infinity_Seeker
 */

?>

<article class="container">

	<h2 class="page-heading"><?php the_title();?></h2>
	<div class="container--page">
		<div class="container--page__visuals">
			<?php echo do_shortcode('[contact-form-7 id="4013" title="Contact"]'); ?>
		</div>

		<div class="container--page__copy ">
			<?php the_content();?>
		</div>
	</div>
	
		
</article>