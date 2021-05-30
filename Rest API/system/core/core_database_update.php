<?php

namespace system\core;

use system\core\database;

/**
 * database_update Class
 *
 * Query access for update data from MySQL database
 * usinjg PDO Driver Extention
 *
 * @package		system
 * @subpackage	core
 * @category	Database Query
 * @throws 		\DBQuery On call Query
 */

	class database_update{

		/**
	    * Initial database name
	    *
	    * @var  string
	    */
		var $database;

		/**
	    * Condition & value
	    *
	    * @var  array
	    */
		var $paramater;

		// --------------------------------------------------------------------

	    /**
	     * Constructor Defauult Access
	     *
	     * @return string
	     */

		function __construct($database, $paramater = array()){

			$this->database = $database;

			$this->paramater = $paramater;

		}

		// --------------------------------------------------------------------

	    /**
	     * Error Handler
	     *
	     * @return mixed
	     */

		function catch_error(){

			try{

				$this->main_query();

				return true;

			}catch(Exception $e){

				return false;

			}

		}

		// --------------------------------------------------------------------

	    /**
	     * Query builder
	     *
	     * @return string
	     */

		function query_command(){

			$query = $this->paramater;

			foreach($query as $key => $val){

				$replace = ["where%%","where%","where>=","where<=","where>","where<","where!","where%","where-"," "];

				$key_index = str_replace($replace,null, $key);

					if(strpos(" ".$key, "where-"))

						$build2[] = $key_index." = '".clean_xss_string($val)."'";

					elseif(strpos(" ".$key, "where%%"))

						$build2[] = $key_index." = '".clean_xss_string($val)."'";

					elseif(strpos(" ".$key, "where%"))

						$build2[] = $key_index." like '%".clean_xss_string($val)."%'";

					elseif(strpos(" ".$key, "where>="))
				
						$build2[] = $key_index." >= ".clean_xss_string($val);

					elseif(strpos(" ".$key, "where<="))
				
						$build2[] = $key_index." <= ".clean_xss_string($val);

					elseif(strpos(" ".$key, "where>"))
				
						$build2[] = $key_index." > ".clean_xss_string($val);

					elseif(strpos(" ".$key, "where<"))
				
						$build2[] = $key_index." < ".clean_xss_string($val);

					elseif(strpos(" ".$key, "where!"))
				
						$build2[] = $key_index." != '".clean_xss_string($val)."'";

					else
						$build1[] = $key_index." = '".str_replace("'",null,$val)."'";
					

			}

			if((isset($build1)) and (isset($build2)))

				$paramater = " SET ".implode(",", $build1)." WHERE ".implode(" and ", $build2);

			elseif((isset($build1)) and (!isset($build2)))

				$paramater = " SET ".implode(",", $build1)." ";

			else $paramater = null;

			return "UPDATE ".$this->database." ".$paramater;
			

		}

		// --------------------------------------------------------------------

	    /**
	     * Query Executor
	     *
	     * @return void
	     */

		function main_query(){

			return (new database)->query($this->query_command());

		}

	}