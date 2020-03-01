<?php
if ( ! defined( 'ABSPATH' ) ) {
    die("Nothing Here!");
} // die if called directly

class ASA_Settings{

    public function __construct()
    {
    }

    public function setup(){
        add_action('admin_menu', [$this, 'add_to_settings_menu'], 100);
        add_action('admin_init', [$this, 'process_save_settings']);
        add_action('asa_crawler_before_settings_form', [$this, 'get_links_from_cache']);
    }

    public function add_to_settings_menu()
    {
        $menu_page = add_options_page(
            __('ASA Crawl', 'asa-crawler'),
            __('ASA Crawl', 'asa-crawler'),
            'manage_options',
            'asa_crawler',
            [$this, 'load_options_page']
        );
    }

    public function load_options_page()
    {
        $this->load_view('settings_form');
    }

    public function process_save_settings()
	{
		if(isset($_POST['action']) && $_POST['action'] == "crawl_now"){
			do_action("asa_save_settings", $_POST);
		}
	}

	public function get_links_from_cache(){
		$cache = new ASA_Cache();
		$links = $cache->get_cache();
		if(!empty($links)){
			$data = compact('links');
			$this->load_view( "links", $data );
		}
	}

	private function load_view($view, $data = []){
		$view_file = ASA_CRAWLER_PLUGIN_DIRECTORY .'views'.DS.$view.".php";
		if( file_exists($view_file) ){
			include $view_file;
		}
	}

}
