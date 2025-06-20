<?php
/*
Plugin Name: Campaignium Hosting
Description: Hide WP Engine UI for anyone whose e-mail is NOT @campaignium.com, plus self-update from GitHub.
Version: 1.2.3
Author:  Campaignium
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ─────────────────────────────────────────────
 * 1.  Hide the WP-Engine sidebar entry (wp-admin)
 * ──────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	if ( ! is_user_logged_in() ) {
		return;
	}
	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		remove_menu_page( 'wpengine-common' );
	}
}, 999 );

/* ─────────────────────────────────────────────
 * 2.  Hide the WP-Engine toolbar item (front- & back-end)
 * ──────────────────────────────────────────── */
add_action( 'admin_bar_menu', function ( WP_Admin_Bar $bar ) {
	if ( ! is_user_logged_in() ) {
		return;
	}
	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		$bar->remove_node( 'wpengine_adminbar' );   // current slug
		$bar->remove_node( 'wpengine-userportal' ); // legacy slug (older installs)
	}
}, 999 );

/*  Fallback CSS in case another plugin re-adds it later with JS.
    Runs on *every* page, not just wp-admin. */
add_action( 'wp_footer',    'campaignium_hide_wpengine_css' );
add_action( 'admin_footer', 'campaignium_hide_wpengine_css' );
function campaignium_hide_wpengine_css() {
	if ( ! is_user_logged_in() ) {
		return;
	}
	$user = wp_get_current_user();
	if ( strpos( $user->user_email, '@campaignium.com' ) === false ) {
		echo '<style>#wp-admin-bar-wpengine_adminbar{display:none!important}</style>';
	}
}


require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Campaignium/Campaignium-Hosting-Plugin/',
    __FILE__,
    'campaignium-hosting'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();
