<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Autoloader.
 * Plugin autoloader, used to require needed files.
 */
class Rocket_Autoloader {

	/**
	 * Rocket_Autoloader constructor.
	 */
	public function __construct() {

	}

	/**
	 * Load / require the files that has classes needed.
	 *
	 * @param string $class_name_with_namespace Name of class to be loaded.
	 */
	public function load( $class_name_with_namespace ) {
		$class_name_parts = explode( '\\', $class_name_with_namespace );
		array_shift( $class_name_parts );// Remove first item in class namespace.

		$class_name      = array_pop( $class_name_parts );// get last item in class namespace and remove it from array.
		$class_file_path = ROCKET_CRAWLER_PLUGIN_DIRECTORY . implode( ROCKET_CRAWLER_DS, $class_name_parts ) . ROCKET_CRAWLER_DS;

		if ( strpos( $class_name, 'Rocket_' ) === 0 ) {
			$class_name       = strtolower( $class_name );
			$class_file_path .= 'class-' . str_replace( '_', '-', $class_name ) . '.php';

			if ( file_exists( $class_file_path ) ) {
				require_once $class_file_path;
			}
		}
	}

}
