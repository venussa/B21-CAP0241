<?php

namespace system\core;

/**
 * system_log Class
 *
 * this class for saving error log
 * into application/cache/logs
 *
 * @package		system
 * @subpackage	core
 * @category	error log
 */

class system_log{

	/**
    * Message data
    *
    * @var  array
    * @return array
    */

	public $message = array();

	// --------------------------------------------------------------------

    /**
     * public constructor
     *
     * @return void
     */

	public function __construct($message = array()){


		$this->message[] = "########################[".date("h:i:s")."]##########################\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Msgs : ".$message['msg']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Type : ".$message['type']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error File : ".$message['e-file']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Line : ".$message['line']."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Date : ".date("d-M-Y")."\r";
		$this->message[] = "------------------------------------------------------------\r";
		$this->message[] = "Error Time : ".date("h:i:s")."\r";
		$this->message[] = "------------------------------------------------------------\r\r\r\r";

		// write error into log file
		write_file(implode(null,$this->message),SERVER."/application/cache/logs/".date("d-M-Y").".log", "a+");

	}

}