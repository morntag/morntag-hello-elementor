<?php
/**
 * This is the child theme for Hello Elementor theme.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
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


 // Stylesheet Gutenberg Editor
add_action('after_setup_theme', 'add_gutenberg_css');

function add_gutenberg_css() {
    add_theme_support('editor-styles');
    add_editor_style('/assets/css/style-editor.css');
}

// Enqueues editor UI styles.
// add_action('enqueue_block_editor_assets', 'simea_gutenberg_ui_css');

function simea_gutenberg_ui_css() {
    wp_enqueue_style('style-editor.css', get_theme_file_uri('style-editor.css'));
}

 // Dequeue Google Fonts loaded by Elementor.
add_filter('elementor/frontend/print_google_fonts', '__return_false'); 

/**
 * Your code goes below
 */
