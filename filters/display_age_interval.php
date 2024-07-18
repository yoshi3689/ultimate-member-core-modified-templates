<?php
function um_profile_field_filter_hook__custom_date( $value, $data ) {
    if ( ! $value ) {
        return '';
    }


        $age = UM()->datetime()->get_age( $value );
        $age_range = get_age_range( $age );
        $value = $age_range . ' (' . $value . ')'; // Appending raw date data


    return $value;
}

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

remove_filter( 'um_profile_field_filter_hook__date', 'um_profile_field_filter_hook__date', 99, 2 );
add_filter( 'um_profile_field_filter_hook__date', 'um_profile_field_filter_hook__custom_date', 999, 2 );
