<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Infinity_Seeker
 */

global $post;
setup_postdata($post);

$featured_image = get_the_post_thumbnail_url();

if ($featured_image) {
    $header_background = $featured_image;
}  else {
    $header_background = '/wp-content/themes/infinity_seeker/images/header.jpg';
}

$content = htmlspecialchars_decode(html_entity_decode(strip_tags(get_the_content())));

if( !empty($content) ){
	if (strlen($content) > 120 ) 
	{
		$maxLength = 120;
		$description = substr($content, 0, $maxLength) . '...';
	} else  {
		$description = $content;
	}
} else {
	$description = 'Daniel Eisenhut is a Swiss based artist who strives to represent undervalued or alienated peoples while questioning social norms.';
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8_unicode_ci" />
	<title>
		<?php  
			
			if ( is_post_type_archive() ){
				$title = post_type_archive_title();
			}
			elseif ( is_archive() ){
				$title = ucwords(single_term_title( "", false ));
			} else {
				$title = get_the_title();
				$title = mb_convert_encoding($title, "HTML-ENTITIES", 'UTF-8');
			}
			echo  ' Daniel Eisenhut | ' . $title;
		?>
	</title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="Daniel Eisenhut - Artist">
	<meta name="description" content="<?php echo $description; ?>">

	<meta property="og:image" content="<?php echo $header_background; ?>" />
	<meta property="twitter:image" content="<?php echo $header_background; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:type" content="blog" />
	<meta property="og:title" content="<?php the_title();?> | Daniel Eisenhut" />
	<meta property="og:url" content="<?php the_permalink();?>" />
	<meta ptoperty="twitter:site" value="@deliveryherocom" />
	<meta ptoperty="twitter:card" content="<?php echo $description; ?>" />
	<meta property="twitter:title" content="<?php the_title();?> | Daniel Eisenhut" />
	<meta property="twitter:url" content="<?php the_permalink();?>" />

	<link rel="manifest" href="manifest.json">

	<!-- <link rel="preload" as="font" href="<?php // echo get_template_directory_uri() ?>/fonts/TenorSans-Regular.woff2" type="font/woff2" crossorigin="anonymous">
  	<link rel="preload" as="font" href="<?php // echo get_template_directory_uri() ?>/fonts/WorkSans-Light.woff2" type="font/woff2" crossorigin="anonymous"> -->

	<?php wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151668836-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-82758638-1');
	</script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'infinity-seeker' ); ?></a>

	<header id="masthead" class="site-header">
	<div class="site-header__inner">
		<div class="site-branding">
			<?php  
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				 $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
				 echo '<a href="/" class="site-logo"><img src="'. $image[0] .'" alt="Daniel Eisenhut Site Logo" /></a>';  
			?>
			
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<!-- .site-branding -->
		</div>
		
		<input type="checkbox" id="navbar-toggler-icon"/>
		<label for="navbar-toggler-icon" class="navbar-toggler-icon"></label>

		<div class="navigation">

            <nav class="navigation__nav">

			

			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>
            </nav>
		</div>
	</div>
		
	</header><!-- #masthead -->

	<div id="content" class="site-content">	