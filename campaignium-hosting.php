<?php
/*
Plugin Name: Campaignium Hosting
Description: Hides the WP Engine dashboard menu for all users except those with an email ending in @campaignium.com.
Version: 1.0.4
Author: Campaignium
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function campaignium_hide_wpengine_menu() {
    if (!is_user_logged_in()) {
        return;
    }

    $user = wp_get_current_user();
    $email = $user->user_email;

    if (strpos($email, '@campaignium.com') === false) {
        remove_menu_page('wpe-common');
    }
}
add_action('admin_menu', 'campaignium_hide_wpengine_menu', 999);

function campaignium_hide_wpengine_menu_css() {
    if (!is_user_logged_in()) {
        return;
    }

    $user = wp_get_current_user();
    $email = $user->user_email;

    if (strpos($email, '@campaignium.com') === false) {
        echo '<style>#toplevel_page_wpe-common { display: none !important; }</style>';
    }
}
add_action('admin_footer', 'campaignium_hide_wpengine_menu_css');

require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Campaignium/Campaignium-Hosting-Plugin/',
    __FILE__,
    'campaignium-hosting'
);

$myUpdateChecker->setAuthentication('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');

$myUpdateChecker->getVcsApi()->enableReleaseAssets();
