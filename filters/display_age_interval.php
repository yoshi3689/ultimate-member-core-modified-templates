<?php
/**
 * Custom filter function to modify the date field on the UM profile.
 *
 * This function calculates the user's age based on the provided date,
 * then determines the age range and appends the raw date to the age range.
 *
 * @param string $value The original date value.
 * @param array  $data  The field data.
 * @return string The modified age range with the raw date.
 */
function um_profile_field_filter_hook__custom_date( $value, $data ) {
    if ( ! $value ) {
        return '';
    }

    // Calculate the user's age from the provided date
    $age = UM()->datetime()->get_age( $value );
    
    // Determine the age range based on the calculated age
    $age_range = get_age_range( $age );
    
    // Append the raw date to the age range
    $value = $age_range . ' (' . $value . ')'; 

    return $value;
}

/**
 * Helper function to determine the age range based on the age.
 *
 * This function returns a string representing the age range for a given age.
 *
 * @param int $age The calculated age.
 * @return string The age range.
 */
function get_age_range( $age ) {
    if ( $age < 20 ) {
        return '~19';
    } elseif ( $age >= 20 && $age <= 30 ) {
        return '20~30';
    } elseif ( $age >= 31 && $age <= 40 ) {
        return '31~40';
    } elseif ( $age >= 41 && $age <= 50 ) {
        return '41~50';
    } elseif ( $age >= 51 && $age <= 60 ) {
        return '51~60';
    } elseif ( $age >= 61 && $age <= 70 ) {
        return '61~70';
    } elseif ( $age >= 71 && $age <= 80 ) {
        return '71~80';
    } else {
        return '80~';
    }
}

/**
 * Remove the default date field filter and add a custom date field filter.
 *
 * This removes the default 'um_profile_field_filter_hook__date' filter with a priority of 99,
 * and adds the custom 'um_profile_field_filter_hook__custom_date' filter with a priority of 999.
 */
remove_filter( 'um_profile_field_filter_hook__date', 'um_profile_field_filter_hook__date', 99, 2 );
add_filter( 'um_profile_field_filter_hook__date', 'um_profile_field_filter_hook__custom_date', 999, 2 );
