<?php

if(!function_exists("encrypt")){

	/**
	 * Encript String to MD5
	 *
	 * Hashing or Encrypting String to MD5 hash
	 *
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */

	function  encrypt($text = null){

		$string = $text;
		
		$string = md5($string);

		write_file($text,SERVER."/application/cache/md5/".$string.".cache","w+");

		return $string;

	}
}

if(!function_exists("decrypt")){

	/**
	 * Decript MD5 to String
	 *
	 * Unhasung or Decripting MD5 to String
	 *
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */

	function  decrypt($text = null){
		
		if(file_exists(SERVER."/application/cache/md5/".$text.".cache") == true){
			
			$read_file = read_file(SERVER."/application/cache/md5/".$text.".cache");

			return $read_file;

		}else{

			return false;

		}

	}
}