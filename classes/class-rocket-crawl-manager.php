<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Crawl_Manager
 */
class Rocket_Crawl_Manager {

	/**
	 * Rocket_Crawl_Manager constructor.
	 */
	public function __construct() {

	}

	/**
	 * Setup Hooks.
	 */
	public function setup() {
		add_action( 'rocket_crawler_save_settings', [ $this, 'crawl_now' ] );

	}

	/**
	 * Run crawling code
	 *
	 * @param array $post_data POST Data.
	 */
	public function crawl_now( $post_data ) {
		$url     = home_url( '/' );
		$request = new Rocket_Request_Url( $url );
		try {
			$request->do_request();
			$links = $request->get_response_body();
			$cache = new Rocket_Cache();
			$cache->set_cache( $links );
		} catch ( Exception $e ) {
			if ( WP_DEBUG ) {
				die( esc_attr( $e->getMessage() ) );
			}
		}

	}

}
