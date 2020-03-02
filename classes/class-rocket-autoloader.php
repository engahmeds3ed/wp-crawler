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
	 * Path to require files from.
	 *
	 * @var string $classes_path
	 */
	private $classes_path;

	/**
	 * Rocket_Autoloader constructor.
	 *
	 * @param string $classes_path Path for classes folder.
	 */
	public function __construct( $classes_path ) {
		$this->classes_path = $classes_path;
	}

	/**
	 * Load / require the files that has classes needed.
	 *
	 * @param string $class_name Name of class to be loaded.
	 */
	public function load( $class_name ) {
		if ( strpos( $class_name, 'Rocket_' ) === 0 ) {
			$class_name      = strtolower( $class_name );
			$class_file_name = 'class-' . str_replace( '_', '-', $class_name ) . '.php';

			$class_file_path = $this->classes_path;
			if ( strpos( $class_name, 'rocket_request' ) === 0 ) {
				$class_file_path .= 'requests' . ROCKET_CRAWLER_DS;
			}
			$class_file_path .= $class_file_name;

			if ( file_exists( $class_file_path ) ) {
				require_once $class_file_path;
			}
		}
	}

}
