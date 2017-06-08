<?php
/**
 * Custom functions
 *
 * @package foundationWP
 */

// Check if sidebar is active
function is_sidebar_active($index) {
    global $wp_registered_sidebars;
    $widgetcolums = wp_get_sidebars_widgets();
    if ($widgetcolums[$index])
        return true;
    return false;
}