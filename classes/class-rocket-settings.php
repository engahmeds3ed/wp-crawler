<?php
/**
 * Settings class to show button and crawling data.
 *
 * @author    Ahmed Saeed <eng.ahmeds3ed@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Settings.
 */
class Rocket_Settings {

	/**
	 * Rocket_Settings constructor.
	 */
	public function __construct() {
	}

	/**
	 * Setup Hooks.
	 */
	public function setup() {
		add_action( 'admin_menu', [ $this, 'add_to_settings_menu' ], 100 );
		add_action( 'admin_init', [ $this, 'process_save_settings' ] );
		add_action( 'rocket_crawler_before_settings_form', [ $this, 'get_links_from_cache' ] );
	}

	/**
	 * Add custom sub-menu inside settings.
	 */
	public function add_to_settings_menu() {
		$menu_page = add_options_page(
			__( 'Rocket Crawl', 'rocket' ),
			__( 'Rocket Crawl', 'rocket' ),
			'manage_options',
			'rocket_crawler',
			[ $this, 'load_options_page' ]
		);
	}

	/**
	 * Load settings page.
	 */
	public function load_options_page() {
		Rocket_Utils::load_view( 'settings_form' );
	}

	/**
	 * Start crawling process.
	 */
	public function process_save_settings() {
		if (
			isset( $_POST['action'] ) &&
			sanitize_text_field( wp_unslash( $_POST['action'] ) ) === 'crawl_now' &&
			isset( $_POST['_wpnonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'crawl_now_form' )
		) {
			$url = home_url( '/' );
			do_action( 'rocket_crawler_save_settings', $url );
		}
	}

	/**
	 * Get links from cache to be previewed.
	 */
	public function get_links_from_cache() {
		$cache = new Rocket_Cache();
		$links = $cache->get_cache();
		if ( ! empty( $links ) ) {
			$data = compact( 'links' );
			Rocket_Utils::load_view( 'links', $data );
		}
	}

}
