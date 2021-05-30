<?php

use system\library\magiccaptcha;

if(!function_exists("create_captcha")){

	/**
	 * Captcha Builder
	 *
	 * Hashing or Encrypting String to MD5 hash
	 *
	 * @param	Boolean
	 * @return	JSon
	 */

	function create_captcha($action = null){
		
		if($action == "code"){

			if(isset($_SESSION['captcha'])){

				return $_SESSION['captcha']['code'];

			}else{

				$_SESSION['captcha'] = (new magiccaptcha)->create_captcha();
		
				$_SESSION["captcha_code"] = $_SESSION['captcha']['code'];

			}

		}else{

			$_SESSION['captcha'] = (new magiccaptcha)->create_captcha();
			
			$_SESSION["captcha_code"] = $_SESSION['captcha']['code'];

			$result = array(
				"code" 	=> $_SESSION['captcha']['code'],
				"captcha_image" => "<img src='". $_SESSION['captcha']['image_src']."' alt='CAPTCHA code'>",
				"captcha_image_url" => $_SESSION['captcha']['image_src'],
			);

			return json_decode(json_encode($result));
		}
	}
}