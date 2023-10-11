<?php
/**
 * Plugin Name: Slideshow Plugin
 * Plugin URI: https://rtcamp.com/
 * Description: Allows to upload photos and create beautiful slideshow.
 * Version: 1.0.0
 * Author: RT Camp
 * Author URI: https://rtcamp.com/
 * Text Domain: rtcamp-slideshow-plugin
 * License: miniOrange
 */

// Add a plugin button to the admin bar.
add_action( 'admin_menu', 'my_menu' );

/**
 * Creating new admin menu
 *
 * @return void
 */
function my_menu() {
	add_menu_page( 'My Page Title', 'Image Slider Pro', 'manage_options', 'my-page-slug', 'my_function' );
}

/**
 * Main content of the page
 *
 * @return void
 */
function my_function() {
	echo 'This is the rT Camp Slideshow Plugin!';
}
