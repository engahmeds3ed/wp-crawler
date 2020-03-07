<?php

namespace Rocket\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly.

/**
 * Class Rocket_Cache
 * used for cache management.
 */
class Rocket_Cache {

	/**
	 * Name for cache entity.
	 *
	 * @var string
	 */
	protected $cache_name = 'rocket_crawler_links';

	/**
	 * Duration to be cached.
	 *
	 * @var float|int
	 */
	protected $cache_ttl = 1 * 60 * 60;// 1 Hour

	/**
	 * Rocket_Cache constructor.
	 */
	public function __construct() {     }

	/**
	 * Save links into cache.
	 *
	 * @param array $value Links to be cached.
	 */
	public function set_cache( $value ) {
		set_transient( $this->cache_name, $value, $this->cache_ttl );
	}

	/**
	 * Get links from the cache
	 *
	 * @return mixed
	 */
	public function get_cache() {
		return get_transient( $this->cache_name );
	}

	/**
	 * Remove links from cache
	 */
	public function remove_cache() {
		delete_transient( $this->cache_name );
	}

}
