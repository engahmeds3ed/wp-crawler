<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Nothing Here!' );
} // die if called directly

class ASA_Cache {

	protected $_name = 'asa_crawler_links';

	protected $_ttl = 1 * 60 * 60;// 1 Hour

	public function __construct() {     }

	public function set_cache( $value ) {
		set_transient( $this->_name, $value, $this->_ttl );
	}

	public function get_cache() {
		return get_transient( $this->_name );
	}

	public function remove_cache() {
		delete_transient( $this->_name );
	}

}
