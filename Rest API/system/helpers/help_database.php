<?php

use system\core\database;

if(!function_exists("database")) {

	/**
	 * database
	 *
	 * @param	String
	 * @return	Mixed
	 */

	function database(){

		return new database();

	}
}