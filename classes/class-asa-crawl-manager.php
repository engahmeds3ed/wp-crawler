<?php
if ( ! defined( 'ABSPATH' ) ) {
    die("Nothing Here!");
} // die if called directly

class ASA_Crawl_Manager{

    public function __construct()
    {

    }

    public function setup(){
		add_action('asa_save_settings', [$this, 'crawl_now']);

    }

    public function crawl_now($post_data)
	{
		$url = home_url('/');
		$request = new ASA_Request_Url($url);
		try{
			$request->do_request();
			$links = $request->get_response_body();
			$cache = new ASA_Cache();
			$cache->set_cache($links);
		}catch (Exception $e){
			if(WP_DEBUG){
				die($e->getMessage());
			}
		}

	}

}
