<?php
/**
 * This is the child theme for Hello Elementor theme.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */

 // Dequeue Google Fonts loaded by Elementor.
add_filter('elementor/frontend/print_google_fonts', '__return_false'); 

/**
 * Stylesheets
 *
 * Parent and child theme stylesheet as well as a stylesheet 
 * for the gutenberg editor.
 */

// Parent stylesheet and custom frontent stylesheet.
add_action('wp_enqueue_scripts', 'morntag_child_hello_elementor_enqueue_styles');

function morntag_child_hello_elementor_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

// Editor stylesheet (backend).
add_action('enqueue_block_editor_assets', 'morntag_editor_style');

function morntag_editor_style() {
  wp_enqueue_style(
    'morntag-editor-style',
    get_stylesheet_directory_uri() . '/assets/css/editor-style.css');
}


/**
 * Frontend and admin scripts
 *
 * Uncomment the hook to activate the respective script.
 */

// Frontend script
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

// Admin script
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

/**
 * Your code goes below
 */
