<?php

namespace system\core;

use system\core\database;

/**
 * database_delete Class
 *
 * Query access for delete data from MySQL database
 * usinjg PDO Driver Extention
 *
 * @package		system
 * @subpackage	core
 * @category	Database Query
 * @throws 		\DBQuery On call Query
 */
	class database_delete{

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

				$replace = [">=","<=",">","<","%%","%","!"," "];

				$key_index = str_replace($replace,null, $key);

					if(strpos(" ".$key, "%%"))

						$build1[] = $key_index." = '".$val."'";

					elseif(strpos(" ".$key, "%"))

						$build1[] = $key_index." like '%".$val."%'";

					elseif(strpos(" ".$key, ">="))
				
						$build2[] = $key_index." >= ".clean_xss_string($val);

					elseif(strpos(" ".$key, "<="))
				
						$build2[] = $key_index." <= ".clean_xss_string($val);

					elseif(strpos(" ".$key, ">"))
				
						$build2[] = $key_index." > ".clean_xss_string($val);

					elseif(strpos(" ".$key, "<"))
				
						$build2[] = $key_index." < ".clean_xss_string($val);

					elseif(strpos(" ".$key, "!"))
				
						$build2[] = $key_index." != '".clean_xss_string($val)."'";

					else
						$build2[] = $key_index." = '".clean_xss_string($val)."'";
					

			}

			if((isset($build1)) and (isset($build2)))

				$paramater = " WHERE (".implode(" or ", $build1).") and ".implode(" and ", $build2);

			elseif((isset($build1)) and (!isset($build2)))

				$paramater = " WHERE (".implode(" or ", $build1).")";

			elseif((!isset($build1)) and (isset($build2)))

				$paramater = " WHERE ".implode(" and ", $build2);

			else $paramater = null;

			return "DELETE FROM ".$this->database." ".$paramater;
			

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