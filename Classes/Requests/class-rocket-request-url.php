<?php

namespace Rocket\Classes\Requests;

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
	public function __construct( $url = '' ) {
		parent::__construct();

		if ( ! empty( $url ) ) {
			$this->set_url( $url );
		}
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
				$link_url = $matches_links[1][ $link_i ];

				if ( $this->is_internal_link( $link_url ) ) {
					$link_text         = $matches_links[2][ $link_i ];
					$output_response[] = [
						'text' => $link_text,
						'url'  => $link_url,
					];
				}
			}
		}

		return $output_response;
	}

	/**
	 * Check if this URL is internal link or not.
	 *
	 * @param string $link Url to be tested.
	 * @return bool True if internal and False if External.
	 */
	private function is_internal_link( $link ) {
		$link_url = wp_parse_url( $link );
		$home_url = wp_parse_url( home_url() );

		return empty( $link_url['host'] ) || $link_url['host'] === $home_url['host'];
	}

}
