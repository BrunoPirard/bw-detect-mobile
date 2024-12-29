<?php if (!defined('ABSPATH')) { exit; }

/**
 * Helper functions for BW Detect Mobile
 */
if (!function_exists('bw_detect')) {
    function bw_detect() {
        if (class_exists('\BW_Detect_Mobile\Main')) {
            return \BW_Detect_Mobile\Main::get_detector();
        }
        return null;
    }
}

if (!function_exists('bw_is_mobile')) {
    function bw_is_mobile() {
        $detector = bw_detect();
        return $detector ? ($detector->isMobile() && !$detector->isTablet()) : false;
    }
}

if (!function_exists('bw_is_tablet')) {
    function bw_is_tablet() {
        $detector = bw_detect();
        return $detector ? $detector->isTablet() : false;
    }
}

if (!function_exists('bw_is_desktop')) {
    function bw_is_desktop() {
        $detector = bw_detect();
        return $detector ? (!$detector->isMobile() && !$detector->isTablet()) : true;
    }
}
