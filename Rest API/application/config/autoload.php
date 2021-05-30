<?php

namespace application\config;

use application\config\autoload;
use application\config\routes;

/**
 * autoload Class
 *
 * This class for load all file config and system
 * and gave some id with namespace
 *
 * @package		application
 * @subpackage	config
 * @category	site config
 */

class autoload {

	/**
	 * get main controller path
	 *
	 * @var string
	 */

	public $main_controller;

	// --------------------------------------------------------------------

    /**
     * dirsystem
     *
     * Register all path component from framework
     *
     * @param void
     * @return string
     * @return array
     */

	private function dirsystem(){
		
		// autoload package
		return array(
			
			"helpers"  		=> SERVER."/system/helpers/*.php",

			"user_helpers"  => SERVER."/application/helpers/*.php",

			"config"   		=> SERVER."/application/config/*.php",

			"core" 			=> SERVER."/system/core/*.php",

			"library"		=> SERVER."/system/library/*.php",

		);
	}

	// --------------------------------------------------------------------

    /**
     * load_data
     *
     * Get Specific path after filtering
     *
     * @param void
     * @return string
     * @return array
     */

	private function load_data(){

		//disallow to load
		$disallow = array("autoload.php");

		$create_function = null;

		// get directory path
		foreach(self::dirsystem() as $key => $val){

			// scanning all filein directory
			foreach (glob($val) as $index => $value) {

				// fille not allowed to load
				$data = explode("/",$value);
				$data = $data[count($data)-1];
				
				if(!in_array($data,$disallow)){				

					$include[] = $value;
				
				}
				
			}

		}


		// return array
		return $include;
	}

	// --------------------------------------------------------------------

    /**
     * file data
     *
     * Get result path from filtering before include
     *
     * @param void
     * @return string
     * @return array
     */

	public function file_data(){

		// get result from load_data() function
		foreach(self::load_data() as $key => $val){

			$data[] = $val;

		}

		// return array
		return $data;

	}

	// --------------------------------------------------------------------

    /**
     *file controller
     *
     * get path main controller file
     *
     * @param void
     * @return string
     * @return array
     */

	public function file_controller(){

		// set main controller file path
		$source = SERVER."/application/register/".$this->main_controller.".php";


		// checking file 
		if(file_exists($source)){
			
			// return string
			return $source;

		}

	}
}

	// --------------------------------------------------------------------

    /**
     * Include alll component framework
     *
     * include all framework component and all function will be hide
     * and we can call that function using namespace
     *
     * @param void
     * @return string
     * @return array
     */

foreach((new autoload)->file_data() as $key => $value)

	require_once($value);


$data = new autoload;
$data->main_controller = "config";

if((new routes)->load_controller()['force_https']){

	if(is_https() == false){

		$data_protocol = str_replace("http://", "https://", documentUrl());

		header("location:".$data_protocol);
		exit;

	}else{

		$data_protocol = str_replace("https://", "http://", documentUrl());

		header("location:".$data_protocol);
		exit;

	}

}


require_once($data->file_controller());