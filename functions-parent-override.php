<?php

/**
 * This function file is loaded after the parent theme's function file. It's a great way to override functions, e.g. add_image_size sizes.
 *
 *
 */

add_filter( 'gb_account_register_user_fields', 'remove_guest_registration_field', 100, 1 );
function remove_guest_registration_field( $fields = array() ) {
	unset($fields['guest_purchase']);
	return $fields;
}