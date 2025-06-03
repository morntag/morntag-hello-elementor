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
add_action( 'enqueue_block_editor_assets', 'morntag_editor_style' );

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
function morntag_enqueue_frontend_scripts() {
	wp_enqueue_script(
		'morntag-frontend-script',
		get_stylesheet_directory_uri() . '/assets/js/frontend.js',
		array(),
		'1.0.0',
		true
	);
}

// add_action('wp_enqueue_scripts', 'morntag_enqueue_frontend_scripts');

/** Admin script */
function morntag_enqueue_admin_scripts() {
	wp_enqueue_script(
		'morntag-admin-script',
		get_stylesheet_directory_uri() . '/assets/js/admin.js',
		array(),
		'1.0.0',
		true
	);
}

// add_action('admin_enqueue_scripts', 'morntag_enqueue_admin_scripts');

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
| Fixing the Skip to Content Button for Elementor
|--------------------------------------------------------------------------
|
| This code fixes the skip to content button on the site for elementor.
| Testet with elementor VXXXXX
|
| @author: Joshy Merki <joshy@morntag.com>
|
*/
add_action( 'elementor/frontend/the_content', 'morntag_add_id_to_first_top_level_element', 1, 1 );
add_filter( 'hello_elementor_skip_link_url', 'morntag_custom_skip_link_url' );

 /*
 * @author: Joshy Merki <joshy@morntag.com>
 * @introduced: 30-May-2025
 * @param string $content The content.
 */
function morntag_add_id_to_first_top_level_element( $html_content ) {

	// Static variable to ensure the ID is added only once per page load,
	// even if this function is called multiple times for different content blocks.
	static $has_skip_content_id = false;

	// Define the Elementor data types that are considered main content containers.
	// We'll search for these attributes in the HTML.
	$main_content_types = [
		'wp-page',     // Typically used for Elementor content on regular pages.
		'single-post'  // Typically used for Elementor content on single post pages.
	];

	// If the HTML content is empty or if we've already added the ID,
	// there's nothing more to do, so return the content as is.
    if ( empty( $html_content ) || $has_skip_content_id ) {
        return $html_content;
    }

	// Check if the target ID 'mcc-content' (wrapped in id="#mcc-content" to be more specific)
	// already exists in the HTML content. If so, mark that we found it and return.
	// This prevents adding duplicate IDs.
	if(str_contains($html_content, 'id="#mcc-content"')){
		$has_skip_content_id = true;
		return $html_content;
	}

	// Loop through each of the defined main content types.
	foreach (	$main_content_types as $type){
		// Construct the specific data attribute string we're looking for.
		// For example, 'data-elementor-type="wp-page"' or 'data-elementor-type="single-post"'.
		$type_html_string = 'data-elementor-type="' . $type . '"';

		// Check if this specific data attribute string exists in the current HTML content.
		if(!str_contains($html_content, $type_html_string)){
			// If not found, skip to the next content type in the $main_content_types array.
			continue;
		}

		// If the data attribute is found, use preg_replace to add ' id="mcc-content"'
		// immediately after the found attribute string.
		// preg_quote is used to escape any special regex characters in $type_html_string.
		// The '1' at the end limits the replacement to only the first occurrence.
		$html_content = preg_replace('/' . preg_quote($type_html_string, '/') . '/', $type_html_string . ' id="mcc-content"', $html_content, 1);
		
		// Set the static flag to true, indicating that we've successfully added the ID.
		$has_skip_content_id = true;

		// Since we've found and modified the first relevant element,
		// return the modified HTML content immediately. No need to check other types.
		return $html_content;
	}

	// If the loop completes without finding any of the specified main content types,
	// return the original HTML content unmodified.
    return $html_content;
}

 /*
 * @author: Joshy Merki <joshy@morntag.com>
 * @introduced: 30-May-2025
 * @param string $url The original skip link URL.
 * @return string The modified skip link URL.
 */
function morntag_custom_skip_link_url( $url ) {
    // The new skip content link
    return '#mcc-content';
}
