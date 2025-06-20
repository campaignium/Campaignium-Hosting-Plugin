<?php
/*
Plugin Name: Campaignium Hosting
Description: Hides the WP Engine sidebar & admin-bar items for anyone whose e-mail
             does NOT end with @campaignium.com.
Version: 1.2.0
Author: Campaignium
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Hide WP Engine in the left sidebar (wp-admin only)
 */
add_action( 'admin_menu', function () {
	if ( ! is_user_logged_in() ) {
		return;
	}

	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		remove_menu_page( 'wpengine-common' );          // sidebar node
	}
}, 999 );

/**
 * 2. Hide WP Engine in the top admin bar (front- and back-end)
 */
add_action( 'admin_bar_menu', function ( WP_Admin_Bar $bar ) {
	if ( ! is_user_logged_in() ) {
		return;
	}

	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		$bar->remove_node( 'wpengine_adminbar' );       // current slug
		$bar->remove_node( 'wpengine-userportal' );     // older slug fallback
	}
}, 999 );

/**
 * 3. Optional CSS fallback (runs everywhere)
 *    — keeps the icon hidden if another plugin re-adds it later with JS/PHP
 */
function campaignium_hide_wpengine_css() {
	if ( ! is_user_logged_in() ) {
		return;
	}

	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		echo '<style>#wp-admin-bar-wpengine_adminbar{display:none!important}</style>';
	}
}
add_action( 'admin_footer', 'campaignium_hide_wpengine_css' );
add_action( 'wp_footer',    'campaignium_hide_wpengine_css' );

require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Campaignium/Campaignium-Hosting-Plugin/',
    __FILE__,
    'campaignium-hosting'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();


error_log('Release asset download URL: ' . $myUpdateChecker->getVcsApi()->getLatestRelease()->downloadUrl);