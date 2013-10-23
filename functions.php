<?php

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'full-foto', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
 
 
// enqueue javascript
if( !function_exists( "theme_js" ) ) {  
  function theme_js(){
  
    wp_register_script( 'bootstrap', 
      get_template_directory_uri() . '/library/js/bootstrap.min.js', 
      array('jquery'), 
      '1.2' );
  
    wp_register_script( 'wpbs-scripts', 
      get_template_directory_uri() . '/library/js/scripts.js', 
      array('jquery'), 
      '1.2' );
	  
	wp_register_script( 'eifix', 
      get_template_directory_uri() . '/library/js/css3-mediaqueries.js', 
      array('jquery'), 
      '1.2' );
  
    wp_register_script(  'modernizr', 
      get_template_directory_uri() . '/library/js/modernizr.full.min.js', 
      array('jquery'), 
      '1.2' );
  
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('wpbs-scripts');
	wp_enqueue_script('eifix');
    wp_enqueue_script('modernizr');
    
  }
}
add_action( 'wp_enqueue_scripts', 'theme_js' );

// Bootstrapped Menu
 require_once('wp_bootstrap_navwalker.php');
 
// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'full-foto') . get_query_var('paged');
    }
} // end get_page_number

// create initial menu
function register_theme_menus() {
      register_nav_menus(
          array( 'main-menu' => __( 'Main Menu' ) )
      );
    }
    add_action( 'init', 'register_theme_menus' );
	
	
	/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function fullfoto_body_class( $classes ) {
	$background_color = get_background_color();
		
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/clearbg.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'imgbackground';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( '000', '000000' ) ) )
		$classes[] = 'custom-background-black';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'fullfoto-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'fullfoto_body_class' );

// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
	
	// This theme uses a custom image size for featured images, displayed on "front" page.
	add_theme_support( 'page-feature' );
	set_post_thumbnail_size( 9999, 480 ); // Unlimited width, soft crop
	
	/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function fullfoto_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
}
add_action( 'customize_register', 'fullfoto_customize_register' );

$args = array(
	'default-color' => '000000',
	'default-image' => get_template_directory_uri() . '/assets/img/home-bg.jpg',
);
add_theme_support( 'custom-background', $args );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 */
function fullfoto_customize_preview_js() {
	wp_enqueue_script( 'fullfoto-customizer', get_template_directory_uri() . '/assets/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'fullfoto_customize_preview_js' );

?>