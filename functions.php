<?php
/*
|--------------------------------------------------------------------------
| MORNTAG CHILD THEME
|--------------------------------------------------------------------------
|
| This is a childtheme based on the hello-elementor theme.
|
*/

/*
|--------------------------------------------------------------------------
| Automatically include PHP files from the /includes directory
|--------------------------------------------------------------------------
|
| This function scans the /includes directory within the theme's root
| and requires all .php files found.
|
*/
$includes_dir = get_stylesheet_directory() . '/includes/';

if ( is_dir( $includes_dir ) ) {
	$files = glob( $includes_dir . '*.php' );

	if ( ! empty( $files ) ) {
		foreach ( $files as $file ) {
			require_once $file;
		}
	}
}

/*
|--------------------------------------------------------------------------
| Your code goes below:
|--------------------------------------------------------------------------
*/

/**
 * This is an example comment
 *
 * Please use this style of comments throughout this file and all includes.
 * Your colleagues, your future self and any developer ever reading your code
 * will be grateful.
 *
 * And remember, be kind!
 *
 * @author: Brian Boy <brian@morntag.com>
 */
