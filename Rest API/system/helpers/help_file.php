<?php

if(!function_exists("read_file")){

	/**
	 * Readfile
	 *
	 * @param	String
	 * @return	String
	 */
	function read_file($path){

		return implode(null,file($path));

	}

}

if(!function_exists("write_file")){

	/**
	 * Write file
	 *
	 * @param	String
	 * @return	void
	 */
	function write_file($text = null,$path = null,$type= null){

		$op = fopen($path,$type);

		if($op){

			fwrite($op,$text);
			fclose($op);

			return true;
		}

	}

}

if(!function_exists("deleteDirectory")){

	/**
	 * Delete Directory
	 *
	 * @param	String
	 * @return	Void
	 */

	function deleteDirectory($dir){

		if (!file_exists($dir)) {
        
        	return true;

   		}

	    if (!is_dir($dir)) {

	        return unlink($dir);

	    }

	    foreach (scandir($dir) as $item) {

	        if ($item == '.' || $item == '..') {
	            continue;
	        }

	        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
	            return false;
	        }

	    }

    return rmdir($dir);

	}

}

if(!function_exists("get_extention")){

	/**
	 * Get Extention
	 *
	 * @param	String
	 * @return	String
	 */
	function get_extention($path){

		$data = explode(".",$path);
		$data = $data[count($data)-1];

		return $data;

	}
}

if(!function_exists("get_file_name")){

	/**
	 * Get file name
	 *
	 * @param	String
	 * @return	String
	 */

	function get_file_name($path){

		$data = explode("/",$path);
		$data = $data[count($data)-1];

		return $data;

	}

}

if(!function_exists("upload")){

	/**
	 * Upload File
	 *
	 * @param	String
	 * @return	String
	 */

	function upload(){

		return new system\library\upload;

	}

}
