<?php
/**
 * @package   Book_Library
 * @author    Alpesh Movaliya
 * @license   
 * @link      
 * @copyright 2019
 *
 * @wordpress-plugin
 * Plugin Name: Library Book Search
 * Plugin URI:  
 * Description: Book has been added by Admin and from Front end we can search books by Name, author, publisher and ratings.
 * Version:     1.0.0
 * Author:      Alpesh
 * Author URI:  
 * License:     
 * License URI: 
 * Text Domain: library-book-search
 * Domain Path: 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
//define( 'BOOK_REVIEWS_FUNC', plugin_dir_path( __FILE__ ) . 'inc/func.php' );

require_once( plugin_dir_path( __FILE__ ) . 'class-book-reviews.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'Book_Reviews', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Book_Reviews', 'deactivate' ) );

Book_Reviews::get_instance();