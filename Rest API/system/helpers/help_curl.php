<?php

use system\library\curlseton;

if(!function_exists("Curl")){

	/**
	 * Curl Set On
	 *
	 * Doing Curl Data From Other SOurce
	 * allowed Empty for secod paramater
	 *
	 * @uses 	CurlSetON
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */

	function Curl($url = false , array $data = array(), array $header = array(), $type = "post"){

		if($url !== false){

			if ($type === "post")
			{	
				$build[CURLOPT_POST] = 1;
				$build[CURLOPT_POSTFIELDS] = http_build_query($data, '', '&');
			}

			$build[CURLOPT_HTTPHEADER] = $header;

			return new curlseton($url,$build);
			
		}
	}

}
