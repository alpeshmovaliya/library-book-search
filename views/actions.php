<?php
// Load public-facing style sheet and JavaScript
add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

// Add the options page and menu item.
add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

// Register post type
add_action('init', array($this, 'my_custom_post_book'));

// Create taxonomy author
add_action('init', array($this, 'add_custom_taxonomies_author'));

// Create taxonomy publisher
add_action('init', array($this, 'add_custom_taxonomies_publisher'));

// add a shortcode
add_shortcode('book-search-library', array($this, 'create_shortcode'));

// AJAX call hook
add_action('wp_ajax_search_books',array($this,'search_books_fun'));
add_action('wp_ajax_nopriv_search_books',array($this,'search_books_fun'));

add_action( 'add_meta_boxes', array($this, 'global_notice_meta_box') );
add_action( 'save_post', array($this, 'save_global_notice_meta_box_data') );
?>