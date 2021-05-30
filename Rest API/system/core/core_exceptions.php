<?php

namespace system\core;

use system\core\system_log;

/**
 * exception Class
 *
 * Read ,Scan and rewrite error into custom error template 
 * and save to log file
 *
 * @package		system
 * @subpackage	core
 * @category	error exception
 */

class exceptions{

	// --------------------------------------------------------------------

    /**
     * List of error type
     *
     * @return array
     * @return mixed
     */

	public function errorType(){
		
		// return error type
		return Array( 
				E_ERROR,
				E_WARNING,
				E_PARSE,
				E_NOTICE,
				E_CORE_ERROR,
				E_CORE_WARNING,
				E_COMPILE_ERROR,
				E_COMPILE_WARNING,
				E_USER_ERROR,
				E_USER_WARNING,
				E_USER_NOTICE,
				E_STRICT,
			);
	}

	// --------------------------------------------------------------------

    /**
     * Error template
     *
     * @return string
     */

	public function catchError($errno, $errstr, $errfile = '', $errline = ''){

		$data  = null;
		$data .= "<div style='border:1px #FF0000 solid;padding:0px;border-radius:5px;margin-top:20px;margin-bottom:20px;background:#f1f1f1;color:#434343'>";
		$data .= "<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
	    $data .= "<tr><td style='width:150px;padding:5px;border-bottom:1px #e2e2e3 solid;'>Eroor Type</td><td style='padding:5px;border-bottom:1px #e2e2e3 solid;border-left:1px #e2e2e3 solid;'>" .$errno. "</td></tr>";
	    $data .= "<tr><td style='width:150px;padding:5px;border-bottom:1px #e2e2e3 solid;'>Eroor Message</td><td style='padding:5px;border-bottom:1px #e2e2e3 solid;border-left:1px #e2e2e3 solid;'>";
	    $split = explode("#",$errstr);
	    $binary = count($split);
	    foreach($split as $key => $val){
	    	if($key > 0){
	    		
	    		$data .= $val."<br>";

	    	}else{

	    		$data .= str_replace("Stack trace:", null, $val);

	    		if($binary > 1){ 
		    		
		    		$data .= "<br>Stack trace : <br>
		    		<div style='margin-left:20px;margin-top:10px;'>";

	    		}
	    	}
	    }

	    $data .= "</div>";

	    $data .= "</td></tr>";
	    $data .= "<tr><td style='width:150px;padding:5px;border-bottom:1px #e2e2e3 solid;'>Erorr File</td><td style='padding:5px;border-bottom:1px #e2e2e3 solid;border-left:1px #e2e2e3 solid;'>" . $errfile. "</td></tr>";
	    $data .= "<tr><td style='width:150px;padding:5px;'>Line Number</td><td style='padding:5px;border-left:1px #e2e2e3 solid;'>" . $errline."</td></tr>";
	    $data .= "</table>";
	    $data .= "</div>";



	   // save rror to log file
		$log = new system_log(array(
            "msg" => $errstr,
            "type" => $errno,
            "line" => $errline,
            "e-file" => $errfile
        ));

		if(isset($_SESSION['debug'])){
			
			if($_SESSION['debug'] == 1){

				echo $data;

			}
		}
	    

	    exit();
} 
}
