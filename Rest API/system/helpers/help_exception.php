<?php

use system\core\exceptions;
use system\core\system_log;


if(!function_exists("handleError")){

    /**
     * catch error exception
     *
     * @param   mixed data
     * @return  string utf8
     */

    function handleError($errno,$errstr,$error_file,$error_line){
        $data  = null;
        $data .= "<div style='border:1px #09f solid;padding:0px;border-radius:5px;margin-top:20px;margin-bottom:20px;background:#f1f1f1;color:#434343'>";
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
        $data .= "<tr><td style='width:150px;padding:5px;border-bottom:1px #e2e2e3 solid;'>Erorr File</td><td style='padding:5px;border-bottom:1px #e2e2e3 solid;border-left:1px #e2e2e3 solid;'>" . $error_file. "</td></tr>";
        $data .= "<tr><td style='width:150px;padding:5px;'>Line Number</td><td style='padding:5px;border-left:1px #e2e2e3 solid;'>" . $error_line."</td></tr>";
        $data .= "</table>";
        $data .= "</div>";

        $log = new system_log(array(
            "msg" => $errstr,
            "type" => $errno,
            "line" => $error_line,
            "e-file" => $error_file
        ));

        if(isset($_SESSION['debug'])){
            
            if($_SESSION['debug'] == 1){

                echo $data;

            }
        }
    }

}


if(!function_exists("ShutDown")){
    
    /**
     * catch error exception if found
     * if some error was found, this function will shutdown all proccess
     * saving and return error to the custom error 
     * @param   mixed data
     * @return  void
     */

    function ShutDown(){
        
        $lasterror = error_get_last();

        $exceptions = new exceptions;

        if(in_array($lasterror['type'],$exceptions->errorType())){

            $exceptions->catchError(

                $lasterror['type'],
                $lasterror['message'],
                $lasterror['file'],
                $lasterror['line']

            );

        }
    } 
}