<?php
/**
 * Utilities static methods class as helpers.
 *
 * @author    Ahmed Saeed <eng.ahmeds3ed@gmail.com>
 */

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
	 */
	public static function load_view( $view, $data = [] ) {
		$view_file = ROCKET_CRAWLER_PLUGIN_DIRECTORY . 'views' . ROCKET_CRAWLER_DS . $view . '.php';
		if ( file_exists( $view_file ) ) {
			include $view_file;
		}
	}

}
