<?php

/*
|--------------------------------------------------------------------------
| Fixing the Skip to Content Button for Elementor
|--------------------------------------------------------------------------
|
| This code fixes the skip to content button on the site for elementor.
|
| @author: Joshy Merki <joshy@morntag.com>
| @introduced: 10-June-2025
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

	$skip_content_id = 'content';

	// Static variable to ensure the ID is added only once per page load,
	// even if this function is called multiple times for different content blocks.
	static $has_skip_content_id = false;

	// Define the Elementor data types that are considered main content containers.
	// We'll search for these attributes in the HTML.
	$main_content_types = array(
		'wp-page',     // Typically used for Elementor content on regular pages.
		'single-post',  // Typically used for Elementor content on single post pages.
	);

	// If the HTML content is empty or if we've already added the ID,
	// there's nothing more to do, so return the content as is.
	if ( empty( $html_content ) || $has_skip_content_id ) {
		return $html_content;
	}

	// Check if the target ID 'content' (wrapped in id="content" to be more specific)
	// already exists in the HTML content. If so, mark that we found it and return.
	// This prevents adding duplicate IDs.
	if ( str_contains( $html_content, 'id="' . $skip_content_id . '"' ) ) {
		$has_skip_content_id = true;
		return $html_content;
	}

	// Loop through each of the defined main content types.
	foreach ( $main_content_types as $type ) {
		// Construct the specific data attribute string we're looking for.
		// For example, 'data-elementor-type="wp-page"' or 'data-elementor-type="single-post"'.
		$type_html_string = 'data-elementor-type="' . $type . '"';

		// Check if this specific data attribute string exists in the current HTML content.
		if ( ! str_contains( $html_content, $type_html_string ) ) {
			// If not found, skip to the next content type in the $main_content_types array.
			continue;
		}

		// If the data attribute is found, use preg_replace to add ' id="content"'
		// immediately after the found attribute string.
		// preg_quote is used to escape any special regex characters in $type_html_string.
		// The '1' at the end limits the replacement to only the first occurrence.
		$html_content = preg_replace( '/' . preg_quote( $type_html_string, '/' ) . '/', $type_html_string . ' id="' . $skip_content_id . '"', $html_content, 1 );

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
	return '#content';
}
