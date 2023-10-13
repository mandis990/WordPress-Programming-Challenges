<?php
/**
 * Plugin Name: Slideshow Plugin
 * Plugin URI:
 * Description: Allows to upload photos and create beautiful slideshow.
 * Version: 1.0.0
 * Author:
 * Author URI:
 * Text Domain: -slideshow-plugin
 * License: s
 */

// Add a plugin button to the admin bar.
add_action( 'admin_menu', 'my_menu' );

function my_menu() {
	add_menu_page( 'My Page Title', 'Image Slider Pro', 'manage_options', 'my-page-slug', 'my_function' );
}

function my_function() {
	// Create a new folder in the main Uploads folder for all images.
	$upload_dir      = wp_upload_dir();
	$new_folder_name = 'slideshow-images'; // Replace this with the name of the folder you want to create.
	$new_folder_path = $upload_dir['basedir'] . '/' . $new_folder_name;

	if ( ! is_dir( $new_folder_path ) ) {
		mkdir( $new_folder_path, 0755, true );
	}

	// Add an upload form.
	?>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="image" />
		<input type="submit" value="Upload" />
	</form>

	<?php

	// Handle the upload.
	upload_images( $new_folder_path );

}

function upload_images( $new_folder_path ) {
	if ( isset( $_FILES['image'] ) && ! $_FILES['image']['error'] ) {
		// Define the upload overrides
		$overrides = array(
			'test_form' => false,
			'action'    => 'wp_handle_upload',
		);
		// Handle the WordPress upload using $_FILES
		$uploaded_file = wp_handle_upload( $_FILES['image'], $overrides );

		if ( isset( $uploaded_file['error'] ) ) {
			echo 'Error uploading image1: ' . $uploaded_file['error'];
		} else {
			$destination = $new_folder_path . '/' . basename( $uploaded_file['file'] );

			if ( rename( $uploaded_file['file'], $destination ) ) {
				echo 'Image uploaded successfully!';
			} else {
				echo 'Error moving uploaded file.';
			}
		}
	}
}


