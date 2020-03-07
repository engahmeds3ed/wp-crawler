<?php
/**
 * Plugin Name: ASA WordPress Crawler
 * Plugin URI: wp-media.net
 * Description: Helps you get/generate link structure for specific page
 * Author: Ahmed Saeed
 * Author URI: #
 * Version: 1.0.0
 * Text Domain: rocket
 * Domain Path: /languages/
 */

use Rocket\Classes\Rocket_Settings;
use Rocket\Classes\Requests\Rocket_Request_Url;
use Rocket\Classes\Rocket_Cache;
use Rocket\Classes\Rocket_Crawl_Manager;
use Rocket\Classes\Rocket_Shortcodes;

/**
 * Class Rocket_Crawler.
 */
class Rocket_Crawler {

	/**
	 * Version of this plugin
	 */
	const VERSION = '1.0.0';

	/**
	 * Rocket_Crawler constructor.
	 */
	public function __construct() {

	}

	/**
	 * Load dependencies and application.
	 */
	public function setup() {
		$this->add_constants();

		// Add autoloader to load all classes inside classes folder when needed.
		$this->setup_autoloader();

		// Load text-domain from the languages folder.
		load_plugin_textdomain( 'wp-crawler', false, ROCKET_CRAWLER_PLUGIN_DIRECTORY . 'languages' );

		$this->start_application();
	}

	/**
	 * Load constants and autoloader for testing.
	 */
	public function setup_test() {
		$this->add_constants();

		// Add autoloader to load all classes inside classes folder when needed.
		$this->setup_autoloader();
	}

	/**
	 * Define constants for plugin.
	 */
	private function add_constants() {
		if( !defined( 'ROCKET_CRAWLER_DS' ) )
			define( 'ROCKET_CRAWLER_DS', DIRECTORY_SEPARATOR );

		if( !defined( 'ROCKET_CRAWLER_PLUGIN_FILE' ) )
			define( 'ROCKET_CRAWLER_PLUGIN_FILE', __FILE__ );

		if( !defined( 'ROCKET_CRAWLER_PLUGIN_DIRECTORY' ) ) {
			if( !defined('ROCKET_IN_TESTING') ) {
				define( 'ROCKET_CRAWLER_PLUGIN_DIRECTORY', plugin_dir_path( ROCKET_CRAWLER_PLUGIN_FILE ) );
			}else{
				define( 'ROCKET_CRAWLER_PLUGIN_DIRECTORY', rtrim( ( dirname( ROCKET_CRAWLER_PLUGIN_FILE ) ), '/\\' ) . ROCKET_CRAWLER_DS );
			}
		}
	}

	/**
	 * Start the main functionality of application after loading dependencies.
	 */
	private function start_application() {
		// Load settings.
		$settings = new Rocket_Settings();
		$settings->setup();

		// Load crawl manager.
		$request       = new Rocket_Request_Url();
		$cache         = new Rocket_Cache();
		$crawl_manager = new Rocket_Crawl_Manager( $request, $cache );
		$crawl_manager->setup();

		// Load shortcodes.
		$shortcodes = new Rocket_Shortcodes();
		$shortcodes->setup();
	}

	/**
	 * Initialize the autoloader to require requested files.
	 */
	private function setup_autoloader() {
		try {
			require_once ROCKET_CRAWLER_PLUGIN_DIRECTORY . 'Classes' . ROCKET_CRAWLER_DS . 'class-rocket-autoloader.php';
			$auto_loader = new Rocket_Autoloader();
			spl_autoload_register( [ $auto_loader, 'load' ] );
		} catch ( Exception $e ) {
			if ( WP_DEBUG ) {
				die( esc_attr( $e->getMessage() ) );
			}
		}

	}

}

/**
 * Main function.
 */
function rocket_crawler_main() {
	$crawler = new Rocket_Crawler();
	$crawler->setup();
}

if( !defined('ROCKET_IN_TESTING') ) {
	// Initialize plugin when plugins are loaded.
	add_action( 'plugins_loaded', 'rocket_crawler_main' );
}
