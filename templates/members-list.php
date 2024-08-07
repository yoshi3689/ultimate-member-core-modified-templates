<?php
// Get current user's role
$current_user_role = UM()->roles()->get_role_name(UM()->user()->get_role());

// Check if the user's role is "Premium" or "Administrator"
$is_premium_or_admin = (strpos($current_user_role, 'Premium') !== false || $current_user_role === 'Administrator');

// Function to get schedule data
function get_schedule_data($schedule_checkbox) {
    // Define the days of the week
    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    // Initialize an array to hold the counts for each day
    $dayCounts = [];

    // Debug statement to log the initial input
    error_log("get_schedule_data called with: " . print_r($schedule_checkbox, true));
    // Optionally, use wp_die to display debug information on the screen
    // wp_die("get_schedule_data called with: " . print_r($schedule_checkbox, true));

    // Check if the schedule_checkbox string is not empty
    if (!empty($schedule_checkbox)) {
        // Loop through each day and count its occurrences in the schedule_checkbox string
        for ($i = 0; $i < count($days); $i++) {
            $dayCounts[$i] = substr_count($schedule_checkbox, $days[$i]);
            // Debug statement to log the count of each day
            error_log("Count for " . $days[$i] . ": " . $dayCounts[$i]);
            // Optionally, use wp_die to display debug information on the screen
            // wp_die("Count for " . $days[$i] . ": " . $dayCounts[$i]);
        }
    } else {
        // If the schedule array is empty, fill the array with -1
        $dayCounts = array_fill(0, count($days), -1);
        // Debug statement to log that the schedule array is empty
        error_log("Schedule array is empty.");
        // Optionally, use wp_die to display debug information on the screen
        // wp_die("Schedule array is empty.");
    }

    // Debug statement to log the final output
    error_log("Final dayCounts: " . print_r($dayCounts, true));
    // Optionally, use wp_die to display debug information on the screen
    // wp_die("Final dayCounts: " . print_r($dayCounts, true));

    // Return the counts for each day
    return $dayCounts;
}



// Function to get schedule symbol
function get_schedule_symbol($count) {
    switch ($count) {
        case 3:
            return '⭑'; // Double Circle
        case 2:
            return '●'; // Circle
        case 1:
            return '▲'; // Triangle
        case -1:
            return 'N/A'; // Not Available
        case 0:
        default:
            return '✗'; // X
    }
}

$unique_hash = substr(md5($args['form_id']), 10, 5);
?>

<script type="text/template" id="tmpl-um-member-list-<?php echo esc_attr($unique_hash) ?>">
    <div class="um-members um-members-list">
        <# if (data.length > 0) { #>
            <# _.each(data, function(user, index, list) { #>
                <div id="um-member-{{{user.card_anchor}}}-<?php echo esc_attr($unique_hash) ?>" class="um-member um-role-{{{user.role}}} {{{user.account_status}}} <?php if ($cover_photos) { echo 'with-cover'; } ?>">
                    <span class="um-member-status {{{user.account_status}}}">
                        {{{user.account_status_name}}}
                    </span>
                    <div class="um-member-card-container">
                        <?php if ($profile_photo) { ?>
                            <div class="um-member-photo radius-<?php echo esc_attr(UM()->options()->get('profile_photocorner')); ?>">
                                <a href="{{{user.profile_url}}}" title="<# if (user.display_name) { #>{{{user.display_name}}}<# } #>">
                                    {{{user.avatar}}}
                                    <?php do_action('um_members_list_in_profile_photo_tmpl', $args); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="um-member-card <?php echo !$profile_photo ? 'no-photo' : '' ?>">
                            <div class="um-member-card-content">
                                <div class="um-member-card-header">
                                    <?php if ($show_name) { ?>
                                        <# if (user.nickname) { #>
                                            <div class="um-member-name">
                                                <a href="{{{user.profile_url}}}" title="{{{user.nickname}}}">
                                                    {{{user.nickname}}}
                                                </a>
                                            </div>
                                        <# } else if (user.display_name_html) { #>
                                            <div class="um-member-name">
                                                <a href="{{{user.profile_url}}}" title="{{{user.display_name}}}">
                                                    {{{user.display_name_html}}}
                                                </a>
                                            </div>
                                        <# } #>
                                    <?php } ?>
                                    {{{user.hook_just_after_name}}}
                                    <?php do_action('um_members_list_after_user_name_tmpl', $args); ?>
                                    {{{user.hook_after_user_name}}}
                                </div>

                                <?php if ($show_tagline && !empty($tagline_fields) && is_array($tagline_fields)) {
                                    foreach ($tagline_fields as $key) {
                                        if (empty($key)) {
                                            continue;
                                        } ?>
                                        <# if (typeof user['<?php echo $key; ?>'] !== 'undefined') { #>
                                            <div class="um-member-tagline um-member-tagline-<?php echo esc_attr($key); ?>" data-key="<?php echo esc_attr($key); ?>">
                                                {{{user['<?php echo $key; ?>']}}}
                                            </div>
                                        <# } #>
                                    <?php }
                                }

                                if ($show_userinfo) { ?>
                                    <# var $show_block = false; #>
                                    <?php foreach ($reveal_fields as $k => $key) {
                                        if (empty($key)) {
                                            unset($reveal_fields[$k]);
                                        } ?>
                                        <# if (typeof user['<?php echo $key; ?>'] !== 'undefined') {
                                            $show_block = true;
                                        } #>
                                    <?php }

                                    if ($show_social) { ?>
                                        <# if (!$show_block) { #>
                                            <# $show_block = user.social_urls #>
                                        <# } #>
                                    <?php } ?>

                                    <# if ($show_block) { #>
                                        <div class="um-member-meta-main<?php if (!$userinfo_animate) { echo ' no-animate'; } ?>">
                                            <# if (true) { #>
                                                <div class="um-member-meta">
                                                    <?php foreach ($reveal_fields as $key) { ?>
                                                        <# if (typeof user.schedule_checkbox !== 'undefined') { #>
                                                            <# if (typeof user.schedule_checkbox !== 'undefined') { #>
                                                                <?php if ($is_premium_or_admin) { ?>
                                                                    <div class="schedule-table-container">
                                                                        <?php 
                                                                        $schedule_checkbox_data = '{{{user["' . $key . '"]}}}';
                                                                        $scheduleData = get_schedule_data($schedule_checkbox_data); 
                                                                        $dayCounts = $scheduleData['dayCounts'];
                                                                        $scheduleArrayConcat = $scheduleData['scheduleArrayConcat'];
                                                                        ?>
                                                                        <table class="schedule-table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <?php $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']; ?>
                                                                                    <?php foreach ($days as $day) { ?>
                                                                                        <th><?php echo $day; ?></th>
                                                                                    <?php } ?>
                                                                                    
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                  <?php foreach ($scheduleData as $day) { ?>
                                                                                        <td><?php echo $day; ?> </td>
                                                                                    <?php } ?>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                <?php } ?>
                                                            <# } #>
                                                        <# } else if (typeof user['<?php echo $key; ?>'] !== 'undefined') { #>
                                                            <div class="um-member-metaline um-member-metaline-<?php echo $key; ?>">
                                                                <strong>{{{user['label_<?php echo $key;?>']}}}:</strong>&nbsp;{{{user['<?php echo $key;?>']}}}
                                                            </div>
                                                        <# } #>
                                                    <?php } ?>
                                                    <?php if ($show_social) { ?>
                                                        <div class="um-member-connect">
                                                            {{{user.social_urls}}}
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <# } #>
                                        </div>
                                    <# } #>
                                <?php } ?>
                            </div>

                            <div class="um-member-card-actions">
                                <# if (Object.keys(user.dropdown_actions).length > 0) { #>
                                    <div class="um-member-cog">
                                        <a href="javascript:void(0);" class="um-member-actions-a">
                                            <i class="um-faicon-cog"></i>
                                        </a>
                                        <?php UM()->member_directory()->dropdown_menu_js('.um-member-cog', 'click', 'user'); ?>
                                    </div>
                                <# } #>
                            </div>
                        </div>
                    </div>

                    <div class="um-member-card-footer <?php echo !$profile_photo ? 'no-photo' : '' ?> <?php if ($show_userinfo && $userinfo_animate) { ?><# if (!$show_block) { #>no-reveal<# } #><?php } ?>">
                        <div class="um-member-card-footer-buttons">
                            <?php do_action('um_members_list_just_after_actions_tmpl', $args); ?>
                        </div>

                        <?php if ($show_userinfo && $userinfo_animate) { ?>
                            <# if ($show_block) { #>
                                <div class="um-member-card-reveal-buttons">
                                    <div class="um-member-more">
                                        <a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a>
                                    </div>
                                    <div class="um-member-less">
                                        <a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a>
                                    </div>
                                </div>
                            <# } #>
                        <?php } ?>
                    </div>
                </div>
            <# }); #>
        <# } else { #>
            <div class="um-members-none">
                <p><?php echo $no_users; ?></p>
            </div>
        <# } #>
    </div>
</script>
