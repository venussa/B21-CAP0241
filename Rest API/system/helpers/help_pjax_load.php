<?php

use system\library\pushstateurl;

if(!function_exists("pjax_load")){

	/**
	 * Pjax load
	 *
	 *
	 * @param	string
	 * @return	void
	 */

	function pjax_load($class = null,$container = null, $content = null, $action = null) {

		$data = new pushstateurl();

		$data->container = $container;

		$data->content 	 = $content;

		$data->class 	 = $class;

		if(is_array($action)) 

			$data->action 	 = $action;

		return json_decode(json_encode(array(

			"javascript" => $data->pjax_start(),
			"class"  	 => $class,
			"data_pjax"  => $content,

		)));
	}

}