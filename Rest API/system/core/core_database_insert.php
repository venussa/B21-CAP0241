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

	class database_insert{

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

				$value = str_replace("'",null, $val);

				$build[$key] = "'".$value."'";

			}

			$index = implode(",", array_keys($build));
			$value = implode(",", ($build));

			return "INSERT INTO ".$this->database." (".$index.") VALUES (".$value.")";
			

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