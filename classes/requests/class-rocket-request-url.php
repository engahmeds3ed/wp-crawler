<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly

/**
 * Class Rocket_Request_Url
 * Grab links from specified link
 */
class Rocket_Request_Url extends Rocket_Request {

	/**
	 * Rocket_Request_Url constructor.
	 *
	 * @param string $url send url in initialization of class.
	 */
	public function __construct( $url = '/' ) {
		parent::__construct();

		$this->set_url( $url );
	}

	/**
	 * Extract links from HTML response.
	 *
	 * @param string $response_html response in HTMl format.
	 * @return array|mixed matched links in array format.
	 */
	protected function adjust_response( $response_html ) {
		$output_response = [];
		$regex_pattern   = '/<a href="([^"]+)">([^<]+)<\/a>/';
		preg_match_all( $regex_pattern, $response_html, $matches_links );

		if ( ! empty( $matches_links ) ) {
			$matches_links_count = count( $matches_links[0] );
			for ( $link_i = 0; $link_i < $matches_links_count;$link_i++ ) {
				$output_response[] = [
					'text' => $matches_links[2][ $link_i ],
					'url'  => $matches_links[1][ $link_i ],
				];
			}
		}

		return $output_response;
	}

}
