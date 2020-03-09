<?php
/**
 * Infinity Seeker functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Infinity_Seeker
 */

if ( ! function_exists('infinity_seeker_setup')) :

/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
function infinity_seeker_setup() {
    /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Infinity Seeker, use a find and replace
		 * to change 'infinity-seeker' to the name of your theme in all the template files.
		 */
    load_theme_textdomain('infinity-seeker', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
    add_theme_support('title-tag');

    /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one Painting Type.
    register_nav_menus(array('menu-1'=> esc_html__('Primary', 'infinity-seeker'),
    ));

    /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
    add_theme_support('html5', array('search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    ));

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('infinity_seeker_custom_background_args', array('default-color'=> 'ffffff',
    'default-image'=> '',
    )));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
    add_theme_support('custom-logo', array('height'=> 250,
    'width'=> 250,
    'flex-width'=> true,
    'flex-height'=> true,
    ));
}

endif;
add_action('after_setup_theme', 'infinity_seeker_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function infinity_seeker_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width']=apply_filters('infinity_seeker_content_width', 640);
}

add_action('after_setup_theme', 'infinity_seeker_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function infinity_seeker_widgets_init() {
    register_sidebar(array('name'=> esc_html__('Sidebar', 'infinity-seeker'),
    'id'=> 'sidebar-1',
    'description'=> esc_html__('Add widgets here.', 'infinity-seeker'),
    'before_widget'=> '<section id="%1$s" class="widget %2$s">',
    'after_widget'=> '</section>',
    'before_title'=> '<h2 class="widget-title">',
    'after_title'=> '</h2>',
    ));
}

add_action('widgets_init', 'infinity_seeker_widgets_init');

/**
 *  Remove junk from header
 */

// Remove Blog and Comments Feed Link from WordPress Head
remove_action('wp_head', 'feed_links', 2);

// Remove RSD Link from WordPress head
remove_action('wp_head', 'rsd_link');

// Remove Manifest Link from WordPress Head
// Disable Windows Live Writer Support
remove_action('wp_head', 'wlwmanifest_link');

// Remove Next Previous Links from WordPress Head
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Remove Emoji Style and Script from WordPress Head
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove dns-prefetch Link from WordPress Head (Frontend)
remove_action('wp_head', 'wp_resource_hints', 2);

// Remove oembed Post Links from WordPress Head (Frontend)
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove WP Json Rest Api link from WordPress Head (Frontend)
remove_action('wp_head', 'rest_output_link_wp_head');

// Remove html5shivmin.js from WordPress Head (Frontend)
function remove_default_scripts3() {
    wp_deregister_script('html5shiv');
}

add_action('wp_enqueue_scripts', 'remove_default_scripts3');


/**
 * Enqueue scripts and styles.
 */

// See: https://core.trac.wordpress.org/ticket/45130 and https://core.trac.wordpress.org/ticket/37110
function wp_jquery_manager_plugin_front_end_scripts() {
    $wp_admin = is_admin();
    $wp_customizer = is_customize_preview();

    // jQuery
    if ( $wp_admin || $wp_customizer ) {
        // echo 'We are in the WP Admin or in the WP Customizer';
        return;
    }
    else {
        // Deregister WP core jQuery, see https://github.com/Remzi1993/wp-jquery-manager/issues/2 and https://github.com/WordPress/WordPress/blob/91da29d9afaa664eb84e1261ebb916b18a362aa9/wp-includes/script-loader.php#L226
        wp_deregister_script( 'jquery' ); // the jquery handle is just an alias to load jquery-core with jquery-migrate
        // Deregister WP jQuery
        wp_deregister_script( 'jquery-core' );
        // Deregister WP jQuery Migrate
        wp_deregister_script( 'jquery-migrate' );

        // Register jQuery in the head
        wp_register_script( 'jquery-core', 'https://code.jquery.com/jquery-3.4.1.min.js', array(), null, false );

        /**
         * Register jquery using jquery-core as a dependency, so other scripts could use the jquery handle
         * see https://wordpress.stackexchange.com/questions/283828/wp-register-script-multiple-identifiers
         * We first register the script and after that we enqueue it, see why:
         * https://wordpress.stackexchange.com/questions/82490/when-should-i-use-wp-register-script-with-wp-enqueue-script-vs-just-wp-enque
         * https://stackoverflow.com/questions/39653993/what-is-diffrence-between-wp-enqueue-script-and-wp-register-script
         */
        wp_register_script( 'jquery', false, array( 'jquery-core' ), null, false );
        wp_enqueue_script( 'jquery' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_jquery_manager_plugin_front_end_scripts' );

function infinity_seeker_scripts() {

    wp_enqueue_style('infinity-seeker-style', get_template_directory_uri() . '/css/style.css');
    
}

add_action('wp_enqueue_scripts', 'infinity_seeker_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

// add svg support
function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
    }
add_action('upload_mimes', 'add_file_types_to_uploads');

// Remove autoformatting
remove_filter('the_content', 'wpautop');

// add class to every menu item
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class($classes, $item){
    $classes[] = 'navigation__item';
    return $classes;
}

// Register Media File custom post type
function MediaFiles() {

    $labels = array(
        'name'                  => 'Media Files',
        'singular_name'         => 'Media File',
        'menu_name'             => 'Media Files',
        'name_admin_bar'        => 'Media Files',
        'archives'              => 'Media File Archives',
        'attributes'            => 'Media File Attributes',
        'parent_item_colon'     => 'Parent Item:',
        'all_items'             => 'All Media Files',
        'add_new_item'          => 'Add New Media File',
        'add_new'               => 'Add New Media File',
        'new_item'              => 'New Media File',
        'edit_item'             => 'Edit Media File',
        'update_item'           => 'Update Media File',
        'view_item'             => 'View Media File',
        'view_items'            => 'View Media Files',
        'search_items'          => 'Search Media File',
        'not_found'             => 'Media File Not found',
        'not_found_in_trash'    => 'Media File Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into item',
        'uploaded_to_this_item' => 'Uploaded to this Media File',
        'items_list'            => 'Media File list',
        'items_list_navigation' => 'Media File list navigation',
        'filter_items_list'     => 'Filter Media File list',
    );
    $args = array(
        'label'                 => 'Media File',
        'description'           => 'Media Files',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'            => array( 'media-file-type'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'menu_icon'             => 'dashicons-media-interactive',

    );
    register_post_type( 'Media File', $args );

}
add_action( 'init', 'MediaFiles', 0 );

// Register Media File Type custom taxonomy
add_action( 'init', 'create_media_file_type_hierarchical_taxonomy', 0 );
 
function create_media_file_type_hierarchical_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Media File Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Media File Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Media File Type' ),
    'all_items' => __( 'Media File Type' ),
    'parent_item' => __( 'Parent Media File Type' ),
    'parent_item_colon' => __( 'Parent Media File Type:' ),
    'edit_item' => __( 'Edit Media File Type' ), 
    'update_item' => __( 'Update Media File Type' ),
    'add_new_item' => __( 'Add New Media File Type' ),
    'new_item_name' => __( 'New Media File Type Name' ),
    'menu_name' => __( 'Media File Types' ),
  );    
 
  register_taxonomy('media_file_types',array('mediafile'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'media-file-type' ),
    'has_archive' => true,
  ));
 
}


// Register Painting custom post type
function Paintings() {

    $labels = array(
        'name'                  => 'Paintings',
        'singular_name'         => 'Painting',
        'menu_name'             => 'Paintings',
        'name_admin_bar'        => 'Paintings',
        'archives'              => 'Painting Archives',
        'attributes'            => 'Painting Attributes',
        'parent_item_colon'     => 'Parent Item:',
        'all_items'             => 'All Paintings',
        'add_new_item'          => 'Add New Painting',
        'add_new'               => 'Add New Painting',
        'new_item'              => 'New Painting',
        'edit_item'             => 'Edit Painting',
        'update_item'           => 'Update Painting',
        'view_item'             => 'View Painting',
        'view_items'            => 'View Paintings',
        'search_items'          => 'Search Painting',
        'not_found'             => 'Painting Not found',
        'not_found_in_trash'    => 'Painting Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => 'Insert into item',
        'uploaded_to_this_item' => 'Uploaded to this Painting',
        'items_list'            => 'Painting list',
        'items_list_navigation' => 'Painting list navigation',
        'filter_items_list'     => 'Filter Painting list',
    );
    $args = array(
        'label'                 => 'Painting',
        'description'           => 'Paintings',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'            => array( 'painting-type'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'menu_icon'             => 'dashicons-admin-customizer',

    );
    register_post_type( 'Painting', $args );

}
add_action( 'init', 'Paintings', 0 );


// Register Painting Type custom taxonomy
add_action( 'init', 'create_painting_type_hierarchical_taxonomy', 0 );
 
function create_painting_type_hierarchical_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Painting Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Painting Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Painting Types' ),
    'all_items' => __( 'Painting Types' ),
    'parent_item' => __( 'Parent Painting Type' ),
    'parent_item_colon' => __( 'Parent Painting Type:' ),
    'edit_item' => __( 'Edit Painting Type' ), 
    'update_item' => __( 'Update Painting Type' ),
    'add_new_item' => __( 'Add New Painting Type' ),
    'new_item_name' => __( 'New Painting Type Name' ),
    'menu_name' => __( 'Painting Types' ),
  );    
 
  register_taxonomy('painting-type',array('painting'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'painting-type' ),
  ));
 
}


// Add page slug to body tag
add_filter( 'body_class', 'body_class_for_pages' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function body_class_for_pages( $classes ) {

	if ( is_singular( 'page' ) ) {
		global $post;
		$classes[] = 'page-' . $post->post_name;
	}

	return $classes;

}

// remove 'protected' from page title
function the_title_trim($title) {

	$title = attribute_escape($title);

	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);

	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);

	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');


function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">...</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
    global $post;
 return '<a class="moretag" href="'. get_permalink($post->ID) . '">...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');