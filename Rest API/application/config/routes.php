<?php

namespace application\config;

/**
 * route Class
 *
 * This class for load all file config and system
 * and gave some id with namespace
 *
 * @package		application
 * @subpackage	config
 * @category	controller set name
 */

class routes{

	// --------------------------------------------------------------------

    /**
     * load controller
     *
     * load controller filename
     *
     * @return void
     * @return array
     */

	public function load_controller(){

		// return array
		return array(

				"default_controller"	=> "index",

				"force_https"			=> false

			);
	}
}