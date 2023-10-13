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
	$current_plugin_path = plugin_dir_path( __FILE__ );
	$new_folder_name     = 'saved-slideshow-images'; // Replace this with the name of the folder you want to create.
	$new_folder_path     = $current_plugin_path . '/' . $new_folder_name;

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
	display_images( $new_folder_path );

}

function upload_images( $new_folder_path ) {
	// update_option('my_uploaded_files_array', array()); exit;
	$uploaded_files_array = get_option( 'my_uploaded_files_array', array() );
	// var_dump($uploaded_files_array);exit;
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
			// var_dump($_FILES['image']);exit;

			if ( rename( $uploaded_file['file'], $destination ) ) {
				echo 'Image uploaded successfully!';
				$uploaded_files_array[] = basename( $destination );
				update_option( 'my_uploaded_files_array', $uploaded_files_array );
			} else {
				echo 'Error moving uploaded file.';
			}
		}
	}
}

function display_images( $new_folder_path ) {
	$uploaded_files_array = get_option( 'my_uploaded_files_array', array() );
	?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
	#sortable {
	  list-style-type: none;
	  margin: 0;
	  padding: 0;
	  width: 60%;
	  border: 1px solid black;
	  padding: 10px;
	}

	#sortable img {
	  margin: 0 3px 3px 3px;
	  width: 100px;
	  height: 100px;
	}
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
	$(function() {
	  $("#sortable").sortable();
	});
  </script>
</head>
<body>

<ul id="sortable">
	<?php
	if ( ! empty( $uploaded_files_array ) ) {
		foreach ( $uploaded_files_array as $file_name ) {
			$img_url = plugin_dir_url( __FILE__ ) . 'saved-slideshow-images/' . $file_name;
			echo '<img src="' . esc_url( $img_url ) . '" width="100" height="100">';
		}
	} else {
		echo 'No images found!';
	}

	?>
</ul>
	<?php
}
?>
