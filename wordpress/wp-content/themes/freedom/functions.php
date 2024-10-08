<?php
/**
 * Freedom functions related to defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

add_action( 'after_setup_theme', 'freedom_setup' );
/**
 * All setup functionalities.
 *
 * @since 1.0
 */
if( !function_exists( 'freedom_setup' ) ) :
function freedom_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 660;

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'freedom', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
	add_theme_support( 'post-thumbnails' );

   // Supporting title tag via add_theme_support (since WordPress 4.1)
   add_theme_support( 'title-tag' );

	// Registering navigation menu.
	register_nav_menu( 'primary', 'Primary Menu' );

	// Cropping the images to different sizes to be used in the theme
	add_image_size( 'featured', 660, 300, true );
	add_image_size( 'featured-home', 485, 400, true );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'freedom_custom_background_args', array(
		'default-color' => 'eaeaea'
	) ) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'chat', 'audio', 'status' ) );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}
endif;

/**
 * Define Directory Location Constants
 */
define( 'FREEDOM_PARENT_DIR', get_template_directory() );
define( 'FREEDOM_CHILD_DIR', get_stylesheet_directory() );

define( 'FREEDOM_INCLUDES_DIR', FREEDOM_PARENT_DIR. '/inc' );
define( 'FREEDOM_CSS_DIR', FREEDOM_PARENT_DIR . '/css' );
define( 'FREEDOM_JS_DIR', FREEDOM_PARENT_DIR . '/js' );
define( 'FREEDOM_LANGUAGES_DIR', FREEDOM_PARENT_DIR . '/languages' );

define( 'FREEDOM_ADMIN_DIR', FREEDOM_INCLUDES_DIR . '/admin' );
define( 'FREEDOM_WIDGETS_DIR', FREEDOM_INCLUDES_DIR . '/widgets' );

define( 'FREEDOM_ADMIN_IMAGES_DIR', FREEDOM_ADMIN_DIR . '/images' );
define( 'FREEDOM_ADMIN_JS_DIR', FREEDOM_ADMIN_DIR . '/js' );
define( 'FREEDOM_ADMIN_CSS_DIR', FREEDOM_ADMIN_DIR . '/css' );


/**
 * Define URL Location Constants
 */
define( 'FREEDOM_PARENT_URL', get_template_directory_uri() );
define( 'FREEDOM_CHILD_URL', get_stylesheet_directory_uri() );

define( 'FREEDOM_INCLUDES_URL', FREEDOM_PARENT_URL. '/inc' );
define( 'FREEDOM_CSS_URL', FREEDOM_PARENT_URL . '/css' );
define( 'FREEDOM_JS_URL', FREEDOM_PARENT_URL . '/js' );
define( 'FREEDOM_LANGUAGES_URL', FREEDOM_PARENT_URL . '/languages' );

define( 'FREEDOM_ADMIN_URL', FREEDOM_INCLUDES_URL . '/admin' );
define( 'FREEDOM_WIDGETS_URL', FREEDOM_INCLUDES_URL . '/widgets' );

define( 'FREEDOM_ADMIN_IMAGES_URL', FREEDOM_ADMIN_URL . '/images' );
define( 'FREEDOM_ADMIN_JS_URL', FREEDOM_ADMIN_URL . '/js' );
define( 'FREEDOM_ADMIN_CSS_URL', FREEDOM_ADMIN_URL . '/css' );

/** Load functions */
require_once( FREEDOM_INCLUDES_DIR . '/custom-header.php' );
require_once( FREEDOM_INCLUDES_DIR . '/functions.php' );
require_once( FREEDOM_INCLUDES_DIR . '/header-functions.php' );

require_once( FREEDOM_ADMIN_DIR . '/meta-boxes.php' );

/** Load Widgets and Widgetized Area */
require_once( FREEDOM_WIDGETS_DIR . '/widgets.php' );

/**
 * Adds support for a theme option.
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/admin/options/' );
	require_once( FREEDOM_ADMIN_DIR . '/options/options-framework.php' );
}

?>