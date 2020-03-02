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
		$this->load_view( 'settings_form' );
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
			do_action( 'rocket_crawler_save_settings', $_POST );
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
			$this->load_view( 'links', $data );
		}
	}

	/**
	 * Load frontend view.
	 *
	 * @param string $view View name.
	 * @param array  $data Data to be passed to the view.
	 */
	private function load_view( $view, $data = [] ) {
		$view_file = ROCKET_CRAWLER_PLUGIN_DIRECTORY . 'views' . ROCKET_CRAWLER_DS . $view . '.php';
		if ( file_exists( $view_file ) ) {
			include $view_file;
		}
	}

}
