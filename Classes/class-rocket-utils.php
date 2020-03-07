<?php
/**
 * Utilities static methods class as helpers.
 *
 * @author    Ahmed Saeed <eng.ahmeds3ed@gmail.com>
 */

namespace Rocket\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Utils
 */
class Rocket_Utils {

	/**
	 * Load frontend view.
	 *
	 * @param string $view View name.
	 * @param array  $data Data to be passed to the view.
	 * @param bool   $return return HTML or echo it.
	 * @return string|null HTML content if $return was true.
	 */
	public static function load_view( $view, $data = [], $return = false ) {
		$view_file = ROCKET_CRAWLER_PLUGIN_DIRECTORY . 'views' . ROCKET_CRAWLER_DS . $view . '.php';

		if ( file_exists( $view_file ) ) {
			if ( $return ) {
				ob_start();
			}

			include $view_file;

			if ( $return ) {
				$contents = ob_get_contents();
				ob_end_clean();
				return $contents;
			}
		}
	}

}
