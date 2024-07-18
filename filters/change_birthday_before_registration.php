<?php
/**
 * Filter to modify the birth date before the registration form is submitted.
 *
 * Changes made to this function:
 * - Modified to handle both the main 'birth_date' and the nested 'submitted' 'birth_date'.
 * - Changed date format back to YYYY/MM/DD.
 * - Date: 2024-07-15
 * - Author: [Your Name or Initials]
 *
 * @param array $post_data The form data being submitted.
 * @param string $mode The mode of the form (register, profile, login).
 * @param array $all_cf_metakeys The form's meta keys.
 * @return array The modified form data.
 */
function modify_birth_date_before_submit( $post_data, $mode, $all_cf_metakeys ) {
    if ( 'register' === $mode ) {
        // Check if 'birth_date' is set in the form object
        if ( isset( $post_data['birth_date'] ) ) {
            $original_date = $post_data['birth_date'];
            $year = date('Y', strtotime(str_replace('/', '-', $original_date)));
            $new_date = $year . '/01/01';
            
            // Update the birth_date in the form data
            $post_data['birth_date'] = $new_date;
        }
        
        // Check if 'birth_date' is set in the nested 'submitted' array
        if ( isset( $post_data['submitted']['birth_date'] ) ) {
            $original_date = $post_data['submitted']['birth_date'];
            $year = date('Y', strtotime(str_replace('/', '-', $original_date)));
            $new_date = $year . '/01/01';
            
            // Update the birth_date in the nested 'submitted' array
            $post_data['submitted']['birth_date'] = $new_date;
        }
    }
    
    return $post_data;
}
add_filter( 'um_submit_form_data', 'modify_birth_date_before_submit', 10, 3 );