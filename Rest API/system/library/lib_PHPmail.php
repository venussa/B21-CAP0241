<?php

 /**
 * PHPmail Class
 *
 * For connecting to SMTP server for sending 
 * Mail message 
 *
 * @package     system
 * @subpackage  library
 * @category    mailing
 */


require SERVER.'/application/plugin/PHPMailer-master/PHPMailerAutoload.php';

use application\config\mailserver;

class PHPmail extends mailserver{
	
	/**
	 * Mail destination
	 *
	 * @var string
	 */
	public $mail_to 		= null;
	
	/**
	 * Mail subject
	 *
	 * @var string
	 */
	public $mail_subject	= null;
	
	/**
	 * Mail message
	 *
	 * @var string
	 */
	public $mail_message	= null;

	/**
	 * Mail name
	 *
	 * @var string
	 */
	public $my_name	= null;
	
	
	// --------------------------------------------------------------------

    /**
	 * Get data config for login to SMTP
     * @param void
     * @return array,json
     */
	protected function getConfig(){
		
		return json_decode(json_encode(self::mail_config()));
		
	}
	
	// --------------------------------------------------------------------

    /**
	 * Set data for sending to destination target
     * @param void
     * @return array,json
     */
	
	protected function message(){
			
		return json_decode(json_encode(array(
			"mailto"	=> $this->mail_to,
			"subject" 	=> $this->mail_subject,
			"message" 	=> $this->mail_message,
			"my_name"	=> $this->my_name
		)));
		
	}
	
	// --------------------------------------------------------------------

    /**
	 * Login lo smtp to get mail access 
     * @param void
     * @return void
     */
	
	protected function mail_login(){
		
		$mail = new PHPMailer();
		$mail ->IsSmtp();
		$mail ->SMTPDebug = 0;
		$mail ->SMTPAuth = true;
		$mail ->SMTPSecure = $this->getConfig()->smtp_secure;
		$mail ->Host = $this->getConfig()->smtp_host;
		$mail ->Port = $this->getConfig()->smtp_port; 
		$mail ->IsHTML(true);
		$mail ->Username = $this->getConfig()->smtp_user;
		$mail ->Password = $this->getConfig()->smtp_pass;
		$mail ->SetFrom($this->getConfig()->smtp_user, $this->message()->my_name);
		$mail ->Subject = $this->message()->subject;
		$mail ->Body = $this->message()->message;
		$mail ->AddAddress($this->message()->mailto);
		
		return $mail;
		
	}

	// --------------------------------------------------------------------

    /**
	 * Execute and sending data
     * @param void
     * @return boolean
     */
	
	public function send(){
		
		if(!$this->mail_login()->Send()){
		   		
			return false;
			
		}else{
			
			return true;
		}
	
	}
	
}