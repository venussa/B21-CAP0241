<?php

use system\library\pagination;

if(!function_exists("pagination")){
	/**
	 * Generate Paging
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function pagination(
			$noPage = 1,
			$dataPerPage = 10,
			$jumData = 0,
			$url = null,
			$container_class = null,
			$list_class = null,
			$a_class = null,
			$pjax = null,
			$list_class_active = null,
			$other_attr = null
		){
		
		$data = new pagination();
		
		return $data->generate(
			$noPage,
			$dataPerPage,
			$jumData,
			$url,
			$container_class,
			$list_class,
			$a_class,
			$pjax,
			$list_class_active,
			$other_attr
		);
		
	}
}