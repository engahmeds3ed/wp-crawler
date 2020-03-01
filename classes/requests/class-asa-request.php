<?php
if ( ! defined( 'ABSPATH' ) ) {
	die("Nothing Here!");
} // die if called directly

abstract class ASA_Request{

	private $url = null;

	private $method = 'GET';

	private $headers = [];

	private $response = null;

	private $response_body = '';

	public function __construct()
	{

	}

	protected function set_url($url)
	{
		$this->url = $url;
	}

	protected function get_url()
	{
		return $this->url;
	}

	protected function set_method($method)
	{
		$this->method = $method;
	}

	protected function get_method()
	{
		return $this->method;
	}

	protected function set_headers($headers)
	{
		$this->headers = $headers;
	}

	protected function get_headers()
	{
		return $this->headers;
	}

	protected function set_response_body($body)
	{
		$this->response_body = $body;
	}

	public function get_response_body()
	{
		return $this->response_body;
	}

	private function empty_response() {
		$this->response = null;
		$this->set_response_body('');
	}

	public function do_request()
	{
		$this->empty_response();

		$this->response = wp_remote_request(
			$this->get_url(),
			[
				'method' => $this->get_method(),
				'headers' => $this->get_headers(),
				'timeout' => apply_filters('asa_crawler_request_timeout', 70)
			]
		);

		// Check if request is an error
		if ( is_wp_error( $this->response ) ) {
			throw new Exception( 'There was a problem connecting to the selected page.' );
		}else{
			$this->set_response_body( $this->adjust_response(isset($this->response['body']) ? $this->response['body'] : '') );
		}
	}

	protected function adjust_response($response)
	{
		return $response;
	}

}
