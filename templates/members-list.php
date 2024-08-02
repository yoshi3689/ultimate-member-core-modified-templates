<?php
// Get current user's role
$current_user_role = UM()->roles()->get_role_name( UM()->user()->get_role() );

// Check if the user's role is "Premium" or "Administrator"
$is_premium_or_admin = (strpos($current_user_role, 'Premium') !== false || $current_user_role === 'Administrator');
?>

<?php
/**
 * Template for the members directory list
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/members-list.php
 *
 * Page: "Members"
 *
 * @version 2.6.1
 *
 * @var array  $args
 * @var bool   $cover_photos
 * @var bool   $profile_photo
 * @var bool   $show_name
 * @var bool   $show_tagline
 * @var bool   $show_userinfo
 * @var bool   $userinfo_animate
 * @var bool   $show_social
 * @var array  $reveal_fields
 * @var string $no_users
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$unique_hash = substr( md5( $args['form_id'] ), 10, 5 ); ?>

<script type="text/template" id="tmpl-um-member-list-<?php echo esc_attr( $unique_hash ) ?>" data-is-premium-or-admin="<?php echo esc_attr($is_premium_or_admin ? 'true' : 'false'); ?>">
    <div class="um-members um-members-list">

        <# if ( data.length > 0 ) { #>
            <# _.each( data, function( user, key, list ) { #>

                <div id="um-member-{{{user.card_anchor}}}-<?php echo esc_attr( $unique_hash ) ?>" class="um-member um-role-{{{user.role}}} {{{user.account_status}}} <?php if ( $cover_photos ) { echo 'with-cover'; } ?>">
                    <span class="um-member-status {{{user.account_status}}}">
                        {{{user.account_status_name}}}
                    </span>
                    <div class="um-member-card-container">
                        <?php if ( $profile_photo ) { ?>
                            <div class="um-member-photo radius-<?php echo esc_attr( UM()->options()->get( 'profile_photocorner' ) ); ?>">
                                <a href="{{{user.profile_url}}}" title="<# if ( user.display_name ) { #>{{{user.display_name}}}<# } #>">
                                    {{{user.avatar}}}

                                    <?php do_action( 'um_members_list_in_profile_photo_tmpl', $args ); ?>
                                </a>
                            </div>
                        <?php } ?>

                        <div class="um-member-card <?php echo ! $profile_photo ? 'no-photo' : '' ?>">
                            <div class="um-member-card-content">
                                <div class="um-member-card-header">
                                    <?php if ( $show_name ) { ?>
                                        <# if ( user.nickname ) { #>
                                            <div class="um-member-name">
                                                <a href="{{{user.profile_url}}}" title="{{{user.nickname}}}">
                                                    {{{user.nickname}}}
                                                </a>
                                            </div>
                                        <# } else if ( user.display_name_html ) { #>
                                            <div class="um-member-name">
                                                <a href="{{{user.profile_url}}}" title="{{{user.display_name}}}">
                                                    {{{user.display_name_html}}}
                                                </a>
                                            </div>
                                        <# } #>
                                    <?php } ?>

                                    {{{user.hook_just_after_name}}}

                                    <?php do_action( 'um_members_list_after_user_name_tmpl', $args ); ?>

                                    {{{user.hook_after_user_name}}}
                                </div>

                                <?php if ( $show_tagline && ! empty( $tagline_fields ) && is_array( $tagline_fields ) ) {
                                    foreach ( $tagline_fields as $key ) {
                                        if ( empty( $key ) ) {
                                            continue;
                                        } ?>

                                        <# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) { #>
                                            <div class="um-member-tagline um-member-tagline-<?php echo esc_attr( $key ); ?>"
                                                 data-key="<?php echo esc_attr( $key ); ?>">
                                                {{{user['<?php echo $key; ?>']}}}
                                            </div>
                                        <# } #>

                                    <?php }
                                }

                                if ( $show_userinfo ) { ?>

                                    <# var $show_block = false; #>

                                    <?php foreach ( $reveal_fields as $k => $key ) {
                                        if ( empty( $key ) ) {
                                            unset( $reveal_fields[ $k ] );
                                        } ?>

                                        <# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) {
                                            $show_block = true;
                                        } #>
                                    <?php }

                                    if ( $show_social ) { ?>
                                        <# if ( ! $show_block ) { #>
                                            <# $show_block = user.social_urls #>
                                        <# } #>
                                    <?php } ?>

                                    <# if ( $show_block ) { #>
                                        <div class="um-member-meta-main<?php if ( ! $userinfo_animate ) { echo ' no-animate'; } ?>">
                                            <# if ( document.querySelector('#tmpl-um-member-list-<?php echo esc_attr( $unique_hash ) ?>').dataset.isPremiumOrAdmin === 'true' ) { #>
                                                <div class="um-member-meta">
                                                    <?php foreach ( $reveal_fields as $key ) { ?>

                                                        <# if ( typeof user['<?php echo $key; ?>'] !== 'undefined' ) { #>
                                                        <div class="um-member-metaline um-member-metaline-<?php echo $key; ?>">
                                                            <strong>{{{user['label_<?php echo $key;?>']}}}:</strong>&nbsp;{{{user['<?php echo $key;?>']}}}
                                                        </div>
                                                        <# } #>

                                                    <?php } ?>

                                                    <?php if ( $show_social ) { ?>
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

                                <# if ( Object.keys( user.dropdown_actions ).length > 0 ) { #>
                                    <div class="um-member-cog">
                                        <a href="javascript:void(0);" class="um-member-actions-a">
                                            <i class="um-faicon-cog"></i>
                                        </a>
                                        <?php UM()->member_directory()->dropdown_menu_js( '.um-member-cog', 'click', 'user' ); ?>
                                    </div>
                                <# } #>

                            </div>

                        </div>
                    </div>
                    <div class="um-member-card-footer <?php echo ! $profile_photo ? 'no-photo' : '' ?> <?php if ( $show_userinfo && $userinfo_animate ) { ?><# if ( ! $show_block ) { #>no-reveal<# } #><?php } ?>">

                        <div class="um-member-card-footer-buttons">
                            <?php do_action( 'um_members_list_just_after_actions_tmpl', $args ); ?>
                        </div>

                        <?php if ( $show_userinfo && $userinfo_animate ) { ?>
                            <# if ( $show_block ) { #>
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

                    <?php if ( $is_premium_or_admin ) { ?>
                    <div class="schedule-table-container">
                        <?php
                        // Insert the schedule table below the specified <div>
                        // Fetch the user's schedule_checkbox data
                        $scheduleText = get_user_meta($user_id, 'schedule_checkbox', true);

                        // Check if the schedule data is already an array
                        if (is_array($scheduleText)) {
                            $scheduleArray = $scheduleText;
                        } else if (is_string($scheduleText)) {
                            // Convert schedule text to an array
                            $scheduleArray = explode(', ', $scheduleText);
                        } else {
                            // If the data is neither array nor string, return
                            echo '<p>Invalid schedule data format.</p>';
                            return;
                        }

                        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        $dayCounts = array_fill_keys($days, 0);

                        // Count occurrences of each day
                        foreach ($scheduleArray as $schedule) {
                            if (is_string($schedule) && strpos($schedule, ' - ') !== false) {
                                list($day, $time) = explode(' - ', $schedule);
                                $day = trim($day);
                                if (isset($dayCounts[$day])) {
                                    $dayCounts[$day]++;
                                }
                            }
                        }

                        // Generate table with symbols
                        echo '<table class="schedule-table"><thead><tr>';
                        foreach ($days as $day) {
                            echo "<th>{$day}</th>";
                        }
                        echo '</tr></thead><tbody><tr>';

                        foreach ($days as $day) {
                            $count = $dayCounts[$day];
                            $symbol = '';
                            switch ($count) {
                                case 3:
                                    $symbol = '⭑'; // Double Circle
                                    break;
                                case 2:
                                    $symbol = '●'; // Circle
                                    break;
                                case 1:
                                    $symbol = '▲'; // Triangle
                                    break;
                                case 0:
                                default:
                                    $symbol = '✗'; // X
                                    break;
                            }
                            echo "<td>{$symbol}</td>";
                        }

                        echo '</tr></tbody></table>';
                        ?>
                    </div>
                    <?php } ?>

                </div>

            <# }); #>
        <# } else { #>

            <div class="um-members-none">
                <p><?php echo $no_users; ?></p>
            </div>

        <# } #>

    </div>
</script>
