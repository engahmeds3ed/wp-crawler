<?php

namespace Rocket\Classes;

use Rocket\Classes\Requests\Rocket_Request;

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
	 * Cache object.
	 *
	 * @var Rocket_Cache|null object of cache.
	 */
	private $cache = null;

	/**
	 * Request Object.
	 *
	 * @var Rocket_Request|null object of request.
	 */
	private $request = null;

	/**
	 * Rocket_Crawl_Manager constructor.
	 *
	 * @param Rocket_Request $request Request object.
	 * @param Rocket_Cache   $cache Cache object.
	 */
	public function __construct( Rocket_Request $request, Rocket_Cache $cache ) {
		$this->cache   = $cache;
		$this->request = $request;
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
		$this->request->set_url( $url );
		try {
			$this->request->do_request();
			$links = $this->request->get_response_body();

			$this->cache->set_cache( $links );
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
			Rocket_Utils::load_view( 'backend/errors', compact( 'rocket_errors' ) );
		}
	}

}
