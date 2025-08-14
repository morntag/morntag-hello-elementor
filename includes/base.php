<?php
/*
|--------------------------------------------------------------------------
| BASE
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Stylesheets
|--------------------------------------------------------------------------
|
| Parent and child theme stylesheet as well as a stylesheet for
| the gutenberg editor.
|
*/

// Parent stylesheet and custom frontent stylesheet.
add_action( 'wp_enqueue_scripts', 'morntag_child_hello_elementor_enqueue_styles' );

function morntag_child_hello_elementor_enqueue_styles() {
	$parent_style_uri = get_template_directory_uri() . '/style.css';
	$parent_style_dir = get_template_directory() . '/style.css';
	$child_style_uri  = get_stylesheet_directory_uri() . '/style.css';
	$child_style_dir  = get_stylesheet_directory() . '/style.css';

	wp_enqueue_style(
		'parent-style',
		$parent_style_uri,
		array(),
		filemtime( $parent_style_dir )
	);

	wp_enqueue_style(
		'child-style',
		$child_style_uri,
		array( 'parent-style' ),
		filemtime( $child_style_dir )
	);
}

// Editor stylesheet (backend).
add_action( 'enqueue_block_assets', 'morntag_editor_style' );

function morntag_editor_style() {
	$editor_style_uri = get_stylesheet_directory_uri() . '/assets/css/editor-style.css';
	$editor_style_dir = get_stylesheet_directory() . '/assets/css/editor-style.css';
	wp_enqueue_style(
		'morntag-editor-style',
		$editor_style_uri,
		array(),
		filemtime( $editor_style_dir )
	);
}


/*
|--------------------------------------------------------------------------
| Frontend and admin scripts
|--------------------------------------------------------------------------
|
| Uncomment the hook to activate the script.
|
*/

/** Frontend script */
// add_action('wp_enqueue_scripts', 'morntag_enqueue_frontend_scripts');

function morntag_enqueue_frontend_scripts() {
	wp_enqueue_script(
		'morntag-frontend-script',
		get_stylesheet_directory_uri() . '/assets/js/frontend.js',
		array(),
		get_stylesheet_directory() . '/assets/js/frontend.js',
		true
	);
}

/** Admin script */
// add_action('admin_enqueue_scripts', 'morntag_enqueue_admin_scripts');


function morntag_enqueue_admin_scripts() {
	wp_enqueue_script(
		'morntag-admin-script',
		get_stylesheet_directory_uri() . '/assets/js/admin.js',
		array(),
		get_stylesheet_directory() . '/assets/js/admin.js',
		true
	);
}

/*
|--------------------------------------------------------------------------
| Dequeue default wp emojis
|--------------------------------------------------------------------------
|
| Removes default wp emoji scripts and styles.
|
*/
add_action( 'init', 'morntag_remove_emoji' );

function morntag_remove_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'morntag_remove_tinymce_emoji' );
}

function morntag_remove_tinymce_emoji( $plugins ) {
	if ( ! is_array( $plugins ) ) {
		return array(); }
	return array_diff(
		$plugins,
		array( 'wpemoji' )
	);
}

/*
|--------------------------------------------------------------------------
| Disable Elementor AI site wide
|--------------------------------------------------------------------------
|
| Elementor AI has to be manually disabled for each user. This filter takes
| care of that automatically, with proper checks to ensure Elementor is
| loaded and the required class properties exist.
|
*/
add_action( 'plugins_loaded', 'morntag_disable_elementor_ai' );

function morntag_disable_elementor_ai() {
	if ( defined( 'ELEMENTOR_VERSION' ) && 
		 class_exists( 'Elementor\Modules\Ai\Preferences' ) && 
		 property_exists( 'Elementor\Modules\Ai\Preferences', 'ENABLE_AI' ) ) {
		add_filter( 'get_user_option_' . Elementor\Modules\Ai\Preferences::ENABLE_AI, '__return_null' );
	}
}
