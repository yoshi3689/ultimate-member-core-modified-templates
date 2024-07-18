<?php
/**
 * Filter to sort the language filter options in the member directory.
 *
 * This function sorts the language filter options for the member directory.
 * It prioritizes languages specified in a predefined order and appends any
 * remaining languages that are not in the specified order.
 *
 * @param array $options The original options array.
 * @param array $atts    The attributes array.
 * @return array The sorted options array.
 */
add_filter("um_member_directory_filter_select_options_sorted", "sort_language_filter_options", 10, 2);
function sort_language_filter_options($options, $atts) {
    // Check if the metakey is "languages"
    if ("languages" == $atts['metakey']) {
        // Define the order of languages
        $languages_order = array(
            'en' => 'English',
            'fr' => 'French'
        );

        $ordered_options = array();

        // Add languages in the specified order
        foreach ($languages_order as $key => $label) {
            if (isset($options[$key])) {
                $ordered_options[$key] = $options[$key];
                unset($options[$key]);
            }
        }

        // Append any remaining options that are not in the specified order
        foreach ($options as $key => $label) {
            $ordered_options[$key] = $label;
        }

        return $ordered_options;
    }

    // Return the original options if the metakey is not "languages"
    return $options;
}
