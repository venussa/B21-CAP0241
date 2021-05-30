<?php

use system\core\method;
use system\core\database;
use system\core\database_insert;
use system\core\database_update;
use system\core\database_select;
use system\core\database_delete;

/**
 * load Class
 *
 * Read views and models
 *
 * @package		system
 * @subpackage	core
 * @category	controller
 */

 class load extends system\core\database {

 	// --------------------------------------------------------------------

    /**
     * call views file
     *
     * @return array
     * @return mixed
     */

 	protected function view($paths = null, $data = null,$print = true){

        if(!is_array($paths)) $newpath[] = $paths;
        else $newpath = $paths;

        $HTML = null;

        foreach($newpath as $fileindex => $filepath){

            $build = null;
            $valuez = null;

            $php_path = SERVER."/application/views/".$filepath.".php";

     		$html_path = SERVER."/application/views/".$filepath.".html";

            if(file_exists($php_path)) $path = $php_path;

            else if(file_exists($html_path)) $path = $html_path;

     		if(!empty($path) and file_exists($path)){

                ob_start();

     			require($path);

                $ob = ob_get_clean();

                $result = $ob;

                if(!empty($data) and is_array($data)){

                    foreach($data as $key => $val){

                        if(!is_array($val)){
                        
                            $build[] = "{{".$key."}}";
                            $valuez[] = $val;

                        }

                    }

                }

                if(is_array($this->get())){
                    
                    foreach($this->get() as $key => $val){

                        if(!is_array($val)){
                        
                            $build[] = "{[".$key."]}";
                            $valuez[] = clean_xss_string($val);

                            $build[] = "{urldecode[".$key."]}";
                            $valuez[] = clean_xss_string(urldecode($val));

                            $build[] = "{urlencode[".$key."]}";
                            $valuez[] = clean_xss_string(urlencode($val));

                        }

                    }

                }

                if(isset($_SESSION)) {
                    
                    foreach($_SESSION as $key => $val){

                        if(!is_array($val)){
                        
                            $build[] = "<[".$key."]>";
                            $valuez[] = clean_xss_string($val);

                            $build[] = "<urldecode[".$key."]>";
                            $valuez[] = clean_xss_string(urldecode($val));

                            $build[] = "<urlencode[".$key."]>";
                            $valuez[] = clean_xss_string(urlencode($val));

                        }

                    }

                }

                if(is_array($this->post())){
                    
                    foreach($this->post() as $key => $val){

                        if(!is_array($val)){
                        
                            $build[] = "([".$key."])";
                            $valuez[] = $val;

                             $build[] = "(urldecode[".$key."])";
                            $valuez[] = urldecode($val);

                            $build[] = "(urlencode[".$key."])";
                            $valuez[] = urlencode($val);

                        }

                    }

                }

                for($i = 1; $i < 10; $i++){

                    $build[] = "S[".$i."]";
                    $valuez[] = splice($i);

                }

                $replace = [

                    "{homeURL}" => HomeUrl(),
                    "{documentURL}" => documentUrl(),
                    "{sourceURL}" => sourceUrl(),
                    "{timestamp}" => time(),

                ];

                $result = str_replace($build,$valuez,$ob);
                $result = str_replace(array_keys($replace), $replace, $result);
                $result = preg_replace("/(\{urldecode\[\w+\]\})/", null, $result);
                $result = preg_replace("/(\{urlencode\[\w+\]\})/", null, $result);
                $result = preg_replace("/(\(urldecode\[\w+\]\))/", null, $result);
                $result = preg_replace("/(\(urlencode\[\w+\]\))/", null, $result);
                $result = preg_replace("/(\{\[\w+\]\})/", null, $result);
                $result = preg_replace("/(\(\[\w+\]\))/", null, $result);


                $HTML .= $result;

     		}else{

                $HTML .= null;

            }

        }

        $split = explode("@if", $HTML);

        if(count($split) > 1){

            foreach($split as $key => $val){

                if($key > 0){

                    $pre_segment = explode("}>", $val);
                    $val = $pre_segment[0];

                    $cond = explode("{", $val);
                    $statement = $cond[1];
                    $cond = explode("==", $cond[0]);                

                    $cond[1] = (empty($cond[1])) ? null : $cond[1];

                    if(trim($cond[0]) == trim($cond[1])){

                        $statements = explode("}", $statement);
                        $segment[] = $statements[0];

                    }else{
                        
                        $statement = explode("else", $val);
                        if(count($statement) > 1){
                            $statement = explode("{", $statement[1]);
                            $statements = explode("}", $statement[1]);
                            $statement = $statements[0]; 
                            $segment[] = $statement;
                        }
                    }

                    $segment[] = $pre_segment[1]; 

                }else $segment[] = $val;

            }

            $HTML = implode(null, $segment);

        }

        if($print == false) return $HTML;

        echo preg_replace("/\s+|\n+|\r/", ' ', $HTML);
        
 	}

    // --------------------------------------------------------------------

    /**
     * call model files
     *
     * @return array
     * @return mixed
     */

    protected function model($path = null){
    
        $path = SERVER."/application/models/".$path.".php";

        if(!empty($path) and file_exists($path)){

            require_once($path);

        }else{

            return false;

        }

    }


    // --------------------------------------------------------------------

    /**
     * method and query reader
     *
     * @return array
     * @return mixed
     */

    function generate_data(){

        return new method();

    }

    function db_query($command = null, $db_name = null){

        if(empty($db_name))

        $db = new database();
        return $db->query($command, $db_name);
        
    }

    function db_insert($database_name = null, $option = array()){

        return (new database_insert($database_name, $option))->catch_error();

    }

    function db_select($database_name = null, $option = array(), $data_type = false){

        $result = (new database_select($database_name, $option))->catch_error();

        return ($data_type == true) ? 

            json_decode(json_encode($result), true) : $result;

    }

    function db_delete($database_name = null, $option = array()){

        return (new database_delete($database_name, $option))->catch_error();

    }

    function db_update($database_name = null, $option = array()){

        return (new database_update($database_name, $option))->catch_error();

    }




    // --------------------------------------------------------------------

    /**
     * Filter get method
     *
     * @return array
     * @return mixed
     */

    protected function get($index = null,$remove = null){

        $get = $this->generate_data()->get($index);

        if(!empty($get)){
            
            if(!empty($remove) and is_array($remove)){

                $get = str_replace($remove,null,$get);

                if(in_array("'",$remove) or in_array('"',$remove)){

                    $get = str_replace(["'","\"","%27","%22"],null,$get);

                }

            }

         return ($get);

        }else{

            return false;

        }

    }

    // --------------------------------------------------------------------

    /**
     * Filter post method
     *
     * @return array
     * @return mixed
     */

    protected function post($index = null,$remove = null){

        $get = $this->generate_data()->post($index);

        if(!empty($get)){
            
            if(!empty($remove) and is_array($remove)){

                $get = str_replace($remove,null,$get);

                if(in_array("'",$remove) or in_array('"',$remove)){

                    $get = str_replace(["'","\"","%27","%22"],null,$get);

                }

            }

            return ($get);

        }else{

            return false;

        }

    }

 }