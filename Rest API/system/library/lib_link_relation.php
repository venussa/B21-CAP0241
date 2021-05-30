<?php

namespace system\library;

use application\config\document;

 /**
 * link_relation Class
 *
 * rewire dir : application\views
 * for include some file from thasts path
 *
 * @package		system
 * @subpackage	library
 * @category	data transmision
 */

class link_relation{

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Set a new virtual path and rewrite path from /application/views/*
	 *
	 * @return	mixed
	 */

	public function __construct(){

		$data = $this->rewriteDocument();

		if($data["status"] == true){

			if(self::getIMG(true)){

				$img = self::getIMG();

				if(self::defined_realpath(true)){

					$path = DirSeparator(SERVER."/sources/".splice());
					
					resize_image($path,null,$img["width"],$img["height"]);

				}	

			}else{

				header($data["header"]);

				echo self::defined_realpath();

			}
			exit;
		}

	}

    // --------------------------------------------------------------------

    /**
     * Filter get method
     *
     * @return array
     * @return mixed
     */

    private function get($index = null,$remove = null){

        $data = parse_url(documentUrl(), PHP_URL_QUERY);

        if(!empty($data)){

        	$split = explode("&", $data);

        	foreach ($split as $key => $value) {
        			
        		$d_val = explode("=", $value);

        		if(count($d_val) > 1){

        			if($d_val[0] == $index)
        				
        				return $d_val[1];

        		}

        	}

        }

    }

	// --------------------------------------------------------------------

	/**
	 * get File name
	 *
	 * Get the original name from uri
	 *
	 * @return	string
	 */

	private function file_name(){

		return get_file_name(splice());

	}

	// --------------------------------------------------------------------

	/**
	 * Read File
	 *
	 * Scan and detection if file found or not found 
	 * if found, this function wiil be read the file target
	 *
	 * @return	bool
	 */

	private function defined_realpath($action = false){

		if(file_exists(DirSeparator(SERVER."/sources/".splice()))) {

			if($action == true){

				return true;

			}else{
					
				return read_file(SERVER."/sources/".splice());

			}

		}else{

			return false;

		}

	}

	// --------------------------------------------------------------------

	/**
	 * manage image info like widht, height and mime
	 *
	 * By scaning internal data of image
	 *
	 * @return	array
	 */

	private function getIMG($is = false){

		$data = getimagesize(SERVER."/sources/".splice());

		$w = (int) self::get("w");
		$h = (int) self::get("h");

		if($is == true){

			if($w == 0 and $h == 0) return false;

			if(is_array($data)) return true;

			return false;

		}

		if(!is_array($data)) return false;

		list($width,$height) = $data;

		if($w == 0 and $h > 0){

			if($h > $height) return false;

			$new_w = $h * 100 / $height;
			$new_w = $new_w * $width / 100;
			$w = $new_w;

		}elseif($w > 0 and $h == 0){

			if($w > $width) return false;

			$new_h = $w * 100 / $width;
			$new_h = $new_h * $height / 100;
			$h = $new_h;

		}elseif($w > 0 and $h > 0){

			$w = $w;
			$h = $h;

		}

		return [
			"width" => $w,
			"height" => $h
		];

	}

	// --------------------------------------------------------------------

	/**
	 * rewrite path of file
	 *
	 * By scanning the content-typr of file
	 *
	 * @return	void
	 */

	private function rewriteDocument(){
		
		$data = (new document)->content_type();

		$extention = get_extention($this->file_name());

		$header["status"] = false;

		if($extention !== "php" and self::defined_realpath(true) and !empty($this->file_name()) and isset($data->$extention) ){

			$data = $data->$extention;

				if(is_array($data)){

					$header["header"] = "Content-type:".$data[0];

				}else{
								
					$header["header"] = "Content-type:".$data;

				}

			$header["status"] = true;
		}	

		return $header;
	}
}