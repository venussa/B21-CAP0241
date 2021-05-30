<?php

use system\library\SimpleImage;

if(!function_exists("generate_image_url")){
	/**
	 * Set image url
	 *
	 * Generate image url
	 *
	 * @param	string
	 * @return	string
	 */
	function generate_image_url($url,$width = null,$height = null ){

		if(!empty($url)){
			
			return (new SimpleImage)->generate_url($url,$width,$height);

		}

	}

}

if(!function_exists("resize_image")){
	/**
	 * Resize image
	 *
	 * COmpress And Resize image with Hight Quality
	 *
	 * @param	string
	 * @param	int
	 * @param	mixed
	 * @return	void
	 * @return	mixed
	 */

	function resize_image($url_image,$save_path = null,$width = null, $height = null){
		
		if(empty($width) or empty($height)){
				
				list($width,$height) = getimagesize($url_image);

		}else{

				if(is_numeric($width) == false or is_numeric($height) == false){
			
					list($width,$height) = getimagesize($url_image);

				}

		}

		$image = new SimpleImage();
		$image->load($url_image);
		$image->resize($width, $height);

		if(empty($save_path)){

			$save = $image->output();

		}else{

			$save = $image->save($save_path);

		}

		if($save){

			return true;
			
		}else{

			return false;
		}
	}
}