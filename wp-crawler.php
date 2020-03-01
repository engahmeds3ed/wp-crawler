<?php
/*
	Plugin Name: ASA WordPress Crawler
	Plugin URI: wp-media.net
	Description: Helps you get/generate link structure for specific page
	Author: Ahmed Saeed
	Author URI: #
	Version: 1.0.0
	Text Domain: rocket
	Domain Path: /languages/
*/

class WP_crawler {

	/**
	 * Version of this plugin
	 */
	const VERSION = '1.0.0';

	/**
	 * WP_crawler constructor.
	 */
	public function __construct() {
		$this->add_constants();
		$this->start_setup();
	}

	private function add_constants() {
		define( 'DS', DIRECTORY_SEPARATOR );
		define( 'ASA_CRAWLER_PLUGIN_FILE', __FILE__ );
		define( 'ASA_CRAWLER_PLUGIN_DIRECTORY', plugin_dir_path( ASA_CRAWLER_PLUGIN_FILE ) );
	}

	/**
	 * Start the plugin main code here
	 */
	private function start_setup() {
		// add autoloader to load all classes inside classes folder when needed
		$this->setup_autoloader();

		// load text-domain from the languages folder
		load_plugin_textdomain( 'wp-crawler', false, ASA_CRAWLER_PLUGIN_DIRECTORY . '/languages' );

		// load settings
		$settings = new ASA_Settings();
		$settings->setup();

		// load crawl manager
		$crawl_manager = new ASA_Crawl_Manager();
		$crawl_manager->setup();

	}

	/**
	 * initialize the autoloader to require requested files
	 */
	private function setup_autoloader() {
		try {
			require_once ASA_CRAWLER_PLUGIN_DIRECTORY . 'classes/class-asa-autoloader.php';
			$autoLoader = new ASA_Autoloader( ASA_CRAWLER_PLUGIN_DIRECTORY . 'classes' . DS );
			spl_autoload_register( [ $autoLoader, 'load' ] );
		} catch ( Exception $e ) {
			if ( WP_DEBUG ) {
				die( $e->getMessage() );
			}
		}

	}

}

/**
 * main function
 */
function __wp_crawler_main() {
	new WP_crawler();
}
// Initialize plugin when plugins are loaded
add_action( 'plugins_loaded', '__wp_crawler_main' );
