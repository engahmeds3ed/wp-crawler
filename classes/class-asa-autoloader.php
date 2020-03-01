<?php
if ( ! defined( 'ABSPATH' ) ) {
    die("Nothing Here!");
} // die if called directly

class ASA_Autoloader{

    private $classes_path;

    public function __construct( $classes_path )
    {
        $this->classes_path = $classes_path;
    }

    public function load( $class_name )
    {
        if (strpos($class_name, 'ASA_') === 0)
        {
            $class_name = strtolower($class_name);
            $class_file_name = "class-".str_replace('_', '-', $class_name).".php";

            $class_file_path = $this->classes_path;
            if(strpos($class_name, "asa_request") === 0 ){
				$class_file_path .= "requests".DS;
			}
            $class_file_path .= $class_file_name;

            if(file_exists($class_file_path)){
                require_once( $class_file_path );
            }
        }
    }

}
