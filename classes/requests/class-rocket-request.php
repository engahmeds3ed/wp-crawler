<?php
/**
 * Main abstract class to send the request
 *
 * @author    Ahmed Saeed <eng.ahmeds3ed@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Request
 * abstract class to be inherited to send the request to get contents of specified resource.
 */
abstract class Rocket_Request {

	/**
	 * URL to get contents.
	 *
	 * @var null
	 */
	private $url = null;

	/**
	 * HTTP method to be used.
	 *
	 * @var string
	 */
	private $method = 'GET';

	/**
	 * Request Headers.
	 *
	 * @var array
	 */
	private $headers = [];

	/**
	 * Response object.
	 *
	 * @var null
	 */
	private $response = null;

	/**
	 * Response body contents.
	 *
	 * @var string
	 */
	private $response_body = '';

	/**
	 * Rocket_Request constructor.
	 */
	public function __construct() {
	}

	/**
	 * Set url for the page you need to get contents.
	 *
	 * @param string $url Page url.
	 */
	protected function set_url( $url ) {
		$this->url = $url;
	}

	/**
	 * Get url for the page you need to get contents.
	 *
	 * @return null
	 */
	protected function get_url() {
		return $this->url;
	}

	/**
	 * Set Http method to send the request with.
	 *
	 * @param string $method HTTP method.
	 */
	protected function set_method( $method ) {
		$this->method = $method;
	}

	/**
	 * Get Http method to send the request with.
	 *
	 * @return string
	 */
	protected function get_method() {
		return $this->method;
	}

	/**
	 * Set headers to be sent with request.
	 *
	 * @param array $headers Array of headers.
	 */
	protected function set_headers( $headers ) {
		$this->headers = $headers;
	}

	/**
	 * Get headers to be sent with request.
	 *
	 * @return array
	 */
	protected function get_headers() {
		return $this->headers;
	}

	/**
	 * Set response body for the current request.
	 *
	 * @param mixed $body Response body.
	 */
	protected function set_response_body( $body ) {
		$this->response_body = $body;
	}

	/**
	 * Return response body for the current request.
	 *
	 * @return string
	 */
	public function get_response_body() {
		return $this->response_body;
	}

	/**
	 * Clear the response contents
	 */
	private function empty_response() {
		$this->response = null;
		$this->set_response_body( '' );
	}

	/**
	 * Send the request
	 *
	 * @throws Exception When request fails.
	 */
	public function do_request() {
		$this->empty_response();

		$this->response = wp_remote_request(
			$this->get_url(),
			[
				'method'  => $this->get_method(),
				'headers' => $this->get_headers(),
				'timeout' => apply_filters( 'rocket_crawler_request_timeout', 70 ),
			]
		);

		// Check if request is an error.
		if ( is_wp_error( $this->response ) ) {
			throw new Exception( 'There was a problem connecting to the selected page.' );
		} else {
			$this->set_response_body( $this->adjust_response( isset( $this->response['body'] ) ? $this->response['body'] : '' ) );
		}
	}

	/**
	 * Adjust response structure
	 *
	 * @param array $response got from curl as is.
	 * @return mixed response after processing
	 */
	protected function adjust_response( $response ) {
		return $response;
	}

}
