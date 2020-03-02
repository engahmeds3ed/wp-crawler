<?php
/**
 * Class to manage Shortcodes.
 *
 * @author    Ahmed Saeed <eng.ahmeds3ed@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Shortcodes.
 */
class Rocket_Shortcodes {

	/**
	 * Rocket_Shortcodes constructor.
	 */
	public function __construct() {
	}

	/**
	 * Setup Hooks.
	 */
	public function setup() {
		add_shortcode( 'rocket_links', [ $this, 'show_rocket_links' ] );
	}

	/**
	 * Shortcode handler for [rocket_links].
	 *
	 * @param array $attributes Shortcode handler.
	 * @return string|null HTML content for links viewer.
	 */
	public function show_rocket_links( $attributes ) {
		$attributes = shortcode_atts(
			[
				'classes' => '',
			],
			$attributes,
			'rocket_links'
		);

		$cache               = new Rocket_Cache();
		$attributes['links'] = $cache->get_cache();

		return Rocket_Utils::load_view( 'frontend/links', $attributes, true );
	}
}
