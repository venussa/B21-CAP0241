<?php

namespace system\core;

use application\config\dbconfig;
use \PDO;

/**
 * database Class
 *
 * Build Query and rewrite query for easy access
 * usinjg PDO Driver Extention
 *
 * @package		system
 * @subpackage	core
 * @category	Database Query
 * @throws 		\DBQuery On call Query
 */

class database extends DBQuery{

	// --------------------------------------------------------------------

	/**
     *Prepare Query
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function prepare($data, $db_name = null){

			$query = self::PDOconnect($db_name)->prepare($data);

			return $query;
		}

	// --------------------------------------------------------------------

	/**
     * Build Query
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function query($data, $db_name = null){

			$query = self::PDOconnect($db_name)->query($data);

			return $query;
		}

	// --------------------------------------------------------------------

	/**
     * Fetch Query as Array
     *
     * @return array
     * @throws \DBQuery On call Query
     */

		public function fetch($data, $db_name = null){
			$query = self::PDOconnect($db_name)->query($data)->fetch();
			return @$query;
		}

	// --------------------------------------------------------------------

	/**
     * Row Count
     *
     * @return string
     * @return numeric
     * @throws \DBQuery On call Query
     */
		public function rowCount($data, $db_name = null){
			$query = self::PDOconnect($db_name)->query($data)->rowCount();
			return @$query;	
		}

	// --------------------------------------------------------------------

	/**
     * Query Fetch Assoc
     *
     * @return mixed
     * @throws \DBQuery On call Query
     */

		public function fetchAssoc($data, $db_name = null){
			$query = self::PDOconnect($db_name)->query($data)->fetch(PDO::FETCH_ASSOC);
			return @$query;
		}

}


class DBQuery extends dbconfig{
	
	// --------------------------------------------------------------------

	/**
     * Connect PDO Driver
     *
     * @return void
     * @return mixed
     * @throws \PDO to connect driver
     */

	protected function PDOconnect($db_name = null){

		if(empty($db_name)) $db_name = (new dbconfig)->information()->database;

		$db = new PDO('mysql:host='.(new dbconfig)->information()->hostname.';dbname='.$db_name,(new dbconfig)->information()->username, (new dbconfig)->information()->password);
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		return $db;

	}

}