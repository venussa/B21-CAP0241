<?php

namespace application\config;

 /**
 * dbconfig Class
 *
 * Setting about database connection information
 * using PDO driver of database
 *
 * @package		application
 * @subpackage	config
 * @category	database config
 */

class dbconfig{

	// --------------------------------------------------------------------

    /**
     * information
     *
     * Set database information
     *
     * @return void
     */

	public function information(){

		// return json object
		return json_decode(json_encode(array(

			"hostname" => "localhost",
			"username" => "root",
			"password" => "gadfrey56",
			"database" => "bangunan"

		)));

	}

}
