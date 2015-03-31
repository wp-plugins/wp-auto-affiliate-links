<?php 


function aal_add_meta_box() {

	$screens = array( 'post' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'aal_sectionid',
			__( 'Auto Affiliate Links', 'aal_textdomain' ),
			'aal_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'aal_add_meta_box' );


function aal_meta_box_callback( $post ) {


	wp_nonce_field( 'aal_meta_box', 'aal_meta_box_nonce' );


	$value = get_option('aal_exclude');
	$old = explode(',', $value);
	$checked = '';
	if(in_array($post->ID,$old)) { $checked = 'checked'; }

	echo '<label for="aal_meta_exclude">';
	_e( '<input type="checkbox" name="aal_meta_exclude" value="1" '. $checked .'> Exclude this post from affiliate linking. ', 'myplugin_textdomain' );
	echo '</label> ';
	//echo $value . '<br>';
}


function aal_save_meta_box_data( $post_id ) {




	if ( ! isset( $_POST['aal_meta_box_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['aal_meta_box_nonce'], 'aal_meta_box' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}


	if ( ! isset( $_POST['aal_meta_exclude'] ) ) {
		// return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['aal_meta_exclude'] );


	
	$old = get_option('aal_exclude');
	$ids = explode(',',$old);
	if($my_data) { if(!in_array($post_id,$ids)) { $checked = 'checked'; } $ids[] = $post_id; }
	else { $ids = array_diff($ids, array(1 => $post_id));   }
	
	$new = implode(',', $ids);
	update_option('aal_exclude', $new);
}


add_action( 'save_post', 'aal_save_meta_box_data' );


?>