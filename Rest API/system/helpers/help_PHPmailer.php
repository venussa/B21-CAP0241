<?php

if(!function_exists("PHPmailer")){

	/**
	 * PHPmailer
	 *
	 * Detecting user device is mobile or not mobile
	 *
	 * @uses 	PHPmailer Library
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function PHPmailer($my_name = null, $mailto = null, $mail_subject = null, $mail_message = null){
		
		$data = new PHPmail();
		
		if(empty($mailto) or empty($mail_subject) or empty($mail_message)) {
			
			return false;
			
		}
		
		$data->my_name		= $my_name;
		$data->mail_to 		= $mailto;
		$data->mail_subject	= $mail_subject;
		$data->mail_message	= $mail_message;
		
		if($data->send()){
			
			return true;
			
		}else{
		
			return false;
			
		}	

	}

}
