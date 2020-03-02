<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Crawl_Manager
 */
class Rocket_Crawl_Manager {

	/**
	 * Set of errors.
	 *
	 * @var array Set of errors.
	 */
	private $errors = [];

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
		add_action( 'admin_notices', [ $this, 'show_admin_errors' ] );
	}

	/**
	 * Set errors attribute.
	 *
	 * @param array $errors Array of errors.
	 */
	public function set_errors( $errors ) {
		$this->errors = $errors;
	}

	/**
	 * Get array of errors.
	 *
	 * @return array Array of errors
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 * Run crawling code
	 *
	 * @param string $url Url to crawl.
	 */
	public function crawl_now( $url ) {
		$request = new Rocket_Request_Url( $url );
		try {
			$request->do_request();
			$links = $request->get_response_body();
			$cache = new Rocket_Cache();
			$cache->set_cache( $links );
		} catch ( Exception $e ) {
			$this->set_errors( [ esc_attr( $e->getMessage() ) ] );
		}

	}

	/**
	 * Show errors for admin.
	 */
	public function show_admin_errors() {
		$rocket_errors = $this->get_errors();
		if ( ! empty( $rocket_errors ) ) {
			Rocket_Utils::load_view( 'errors', compact( 'rocket_errors' ) );
		}
	}

}
