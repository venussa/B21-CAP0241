<?php

use system\library\user_agent;

if(!function_exists("is_mobile")){
	/**
	 * Is mobile
	 *
	 * Detecting user device is mobile or not mobile
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function is_mobile(){

		return (new user_agent)->is_mobile();

	}

}

if(!function_exists("is_browser")){
	/**
	 * Is Browser
	 *
	 * Detecting user device is mobile or not mobile
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function is_browser(){

		return (new user_agent)->is_browser();

	}

}

if(!function_exists("is_robot")){
	/**
	 * Is robot
	 *
	 * Detecting user device is mobile or not mobile
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function is_robot(){

		return (new user_agent)->is_robot();

	}

}

if(!function_exists("is_referral")){
	/**
	 * Is referral
	 *
	 * Detecting user device is mobile or not mobile
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function is_referral(){

		return (new user_agent)->is_referral();

	}

}

if(!function_exists("agent_string")){
	/**
	 * agent_string
	 *
	 * Detecting agent string
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function agent_string(){

		return (new user_agent)->agent_string();

	}

}

if(!function_exists("platform")){
	/**
	 * plathform
	 *
	 * detecting user platform
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function platform(){

		return (new user_agent)->platform();

	}

}

if(!function_exists("browser")){
	/**
	 * browser
	 *
	 * decterting user browser
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function browser(){

		return (new user_agent)->browser();

	}

}

if(!function_exists("version")){
	/**
	 * version
	 *
	 * Get Browser Version
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function version(){

		return (new user_agent)->version();

	}

}

if(!function_exists("robot")){
	/**
	 * robot
	 *
	 * Get robots name
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function robot(){

		return (new user_agent)->robot();

	}

}

if(!function_exists("mobile")){
	/**
	 * mobile
	 *
	 * Get device name
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function mobile(){

		return (new user_agent)->mobile();

	}

}

if(!function_exists("referrer")){
	/**
	 * referrer
	 *
	 * Detecting who refering site user
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function referrer(){

		return (new user_agent)->referrer();

	}

}

if(!function_exists("languages")){
	/**
	 * Languages
	 *
	 * Detecting User Language
	 *
	 * @uses 	useragent class
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */
	function languages(){

		return (new user_agent)->languages();

	}

}