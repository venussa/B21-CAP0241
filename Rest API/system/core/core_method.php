<?php

namespace system\core;

use system\core\controller;

/**
 * method Class
 *
 * Filtering paramater from GET / POST / SESSION / COOKIE / SERVER / FILES
 * and to clean xss / character non utf8
 *
 * @package		system
 * @subpackage	core
 * @category	filter paramater
 */

class method{

	/**
    * url splitter and get method reader
    *
    * @var  array
    */

	private $identification = array("?","=");

	/**
    * uri splitter
    *
    * @var  array
    */

	private $splice_data = array("&");

	// --------------------------------------------------------------------

    /**
     * Reade GET Mehod
     *
     * @return array
     * @return string
     * @return method
     */

		public function get($index = null){

			// fetch data
			$start = @explode($this->identification[0],documentUrl());

			if(isset($start[1])){
				$split = @explode($this->splice_data[0],$start[1]);

				// checking visible paramater
				foreach ($split as $key => $value) {

						$extract = explode($this->identification[1], $value);
						
						if(!empty($index)){

						$response = true;

						// check allowing paramater
						if($index == $extract[0]){
						
						return $extract[1];

					// if no config found
					}else{

					}
				}else{

				// commbine data
				$response = false;
				
				if(isset($extract[1]))

					$result[$extract[0]] = $extract[1];
				else
					$result[$extract[0]] = null;
							
				}
			}

				// return all
				if($response == false){

					return $result;

				}

			}else{

				// if method get not found
				return array();
			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade POST Method
     *
     * @return array
     * @return string
     * @return method
     */

		public function post($index = null){

			if(!empty($index)){

				foreach ($_POST as $key => $value) {

					if($index == $key){
						
						return $value;
					}
				}	

			}else{

				return $_POST;

			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade SESSION Mehod
     *
     * @return array
     * @return string
     * @return method
     */
		
		public function session($index = null,$val = null){

			if(!empty($val)){

			$_SESSION[$index] = $val;

			}else{

			if(!empty($index)){

				foreach ($_SESSION as $key => $value) {

					if($index == $key){
						return $value;
						}
					}	

				}else{

					return $_SESSION;

				}
			}
		}

	// --------------------------------------------------------------------

    /**
     * Reade SERVER Mehod
     *
     * @return array
     * @return string
     * @return method
     */
		
		public function server($index = null){

			if(!empty($index)){

				foreach ($_SERVER as $key => $value) {

					if($index == $key){

						return $value;

					}
				}	

			}else{

				return $_SERVER;
			}
		}
}