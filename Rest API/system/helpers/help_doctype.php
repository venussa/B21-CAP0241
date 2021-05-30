<?php

use application\config\document;

if(!function_exists("content_type")){

	/**
	 * Get content type
	 *
	 * @param	String
	 * @return	string
	 */

	function content_type($data = null){

		if(empty($data)) return false;

		$data = (new document)->content_type()->$data;

		if($data == false) return false;

		if(is_array($data)) return $data[0];

		return $data;

	}

}


if(!function_exists("header_content_type")){

	/**
	 * Header content type
	 *
	 * Set default document content type
	 * and force redirect
	 *
	 * @param	String
	 * @return	void
	 */

	function header_content_type($data = null){

		if(empty($data)) return false;

		$data = content_type($data);

		header("Content-type:".$data);

	}

}


if(!function_exists("document_type")){

	/**
	 * Get document type
	 *
	 * @param	String
	 * @return	string
	 */

	function document_type($data = null){

		if(empty($data)) return false;

		$data = (new document)->document_type()[$data];

		if($data == false) return false;

		return $data;

	}

}