<?php
function um_custom_validate_birth_date( $args ) {
	if ( ! empty( $args['birth_date'] ) ) {
		// Birth date as a Unix timestamp.
		$then = strtotime( $args['birth_date'] );

		// A person 17'th birthday as a Unix timestamp.
		$adulthood = strtotime( '+17 years', $then );

		// Current time.
		$now = time();

		if ( $now < $adulthood ) {
			UM()->form()->add_error( 'birth_date', __( 'You have to be over 16 years old to register for our service.', 'ultimate-member' ) );
		}
	}
}
add_action( 'um_submit_form_errors_hook_', 'um_custom_validate_birth_date', 30, 1 );