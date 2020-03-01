<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly

class ASA_Request_Url extends ASA_Request {

	public function __construct( $url = '/' ) {
		parent::__construct();

		$this->set_url( $url );
	}

	protected function adjust_response( $response_html ) {
		$output_response = [];
		$regex_pattern   = '/<a href="([^"]+)">([^<]+)<\/a>/';
		preg_match_all( $regex_pattern, $response_html, $matches_links );

		if ( ! empty( $matches_links ) ) {
			for ( $link_i = 0; $link_i < count( $matches_links[0] );$link_i++ ) {
				$output_response[] = [
					'text' => $matches_links[2][ $link_i ],
					'url'  => $matches_links[1][ $link_i ],
				];
			}
		}

		return $output_response;
	}

}
