<?php
/**
 * Plugin Name: LTK Remove Branding
 * Plugin URI: https://wordpress.org/plugins/ltk-remove-branding/
 * Description: Remove WordPress links and logos from your website with this plugin.
 * Version: 1.1.1
 * Author: Mootex
 * Author URI: https://mootex.co/
 */

class LTK_RemoveBranding {

	/**
	 * Hooks plugin's code into WordPress
	 */
	public function init() {

		add_action( 'wp_before_admin_bar_render', [$this, 'remove_admin_bar_logo'] );
		remove_action( 'wp_head', 'wp_generator' );

		add_action( 'login_enqueue_scripts', [$this, 'remove_login_logo'], 9 );

		// Remove only if in the admin dashboard
		if ( is_admin() ) {
			add_action( 'admin_head', [$this, 'remove_excerpt_help_text'] );
			add_action( 'admin_head', [$this, 'remove_help_menu'] );
			add_action( 'admin_init', [$this, 'remove_update_notice'] );
			add_action( 'admin_init', [$this, 'remove_meta_boxes'] );
			add_filter( 'admin_footer_text', [$this, 'remove_footer_credits'] );
			add_action( 'admin_menu', [$this, 'remove_footer_version'] );
		}

	}

	/**
	 * Remove WordPress logo from the admin bar
	 */
	public function remove_admin_bar_logo() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
	}

	/**
	 * Removes help text in excerpt box
	 *
	 * The excerpt help points to WordPress documentation, that's why. It's not
	 * really helpful for users either.
	 */
	public function remove_excerpt_help_text() {
		echo '<style type="text/css">textarea#excerpt + p { display: none; }</style>';
	}

	/**
	 * Remove contextual help menu
	 */
	public function remove_help_menu() {
		echo '<style type="text/css">#contextual-help-link-wrap { display: none !important; }</style>';
	}

	/**
	 * Remove WordPress update notice
	 */
	public function remove_update_notice() {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}

	/**
	 * Remove unnecesary dashboard widgets
	 */
	public function remove_meta_boxes() {

		// "Welcome"
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

		// "WordPress news"
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );

		// "At a glance" (impossible to remove "WordPress {v} running theme...")
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	}

	/**
	 * Remove "Thanks for creating with WordPress"
	 */
	public function remove_footer_credits() {
		return '';
	}

	/**
	 * Remove version number from footer
	 */
	public function remove_footer_version() {
		remove_filter( 'update_footer', 'core_update_footer' );
	}

	/**
	 * Removes Wordpress version from RSS
	 */
	public function remove_generator() {
		return '';
	}

	/**
	 * Removes the WordPress logo in login page
	 *
	 * To undo this and show your custom logo, unhook the function or add your
	 * own logo later. This is executed with a priority of 9.
	 */
	public function remove_login_logo() {
		echo '<style type="text/css">.login h1 { display: none !important; }</style>';
	}

}

$LTK_RemoveBranding = new LTK_RemoveBranding();
$LTK_RemoveBranding->init();
