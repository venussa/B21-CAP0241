<?php

use application\config\routes;
use system\core\method;
use system\library\user_agent;
use system\library\link_relation;
use system\library\SimpleImage;

/**
 * controller Class
 *
 * this class controlling all bout site and any function
 * to load on your project
 *
 * @package		system
 * @subpackage	core
 * @category	site controller
 */

class controller{

	// --------------------------------------------------------------------

    /**
     * Rewrite Permalink
     *
     * @return void
     * @return mixed
     */

	public function declarate_space(){

		(new link_relation);

		$config = false;

		$data = glob(SERVER."/application/controllers/*.php");

		$tmp = [];
		
		foreach ($data as $key => $value) {
			
			$real_path = explode("/", $value);
			$real_path = $real_path[count($real_path) - 1];

			$replace = str_replace(".php",null, $real_path);

			if($replace !== (new routes)->load_controller()["default_controller"])

				$tmp[] = $replace;

		}

		$data = $tmp;

		if(!empty(splice(1)) and (splice(1) !== "index.php")) {
			
			// checking and sellection
			
			if(in_array(splice(1),$data)) {

				// amp mode detection

				foreach($data as $key => $val){

					if(splice(1) == $val){

						// url found
						$path = SERVER."/application/controllers/".$val.".php";

						if(file_exists(DirSeparator($path))){	
		    			
			    			set_error_handler("handleError");
			    			
			    			register_shutdown_function('ShutDown');
			    		
				            require_once(DirSeparator($path));

				            ob_start();

				            $def_class = splice(1);

				            if(class_exists($def_class))
				            $call_class = new $def_class();

				        	else{
				        		$this->notfound();
				        		exit;
				        	}

				            $ob = ob_get_clean();			



							if(!empty(splice(2))){

								$models_path = SERVER."/application/models/".splice(1)."/".splice(2).".php";

								if(file_exists($models_path)){

									require_once($models_path);

									$models_name = splice(2);

									if(class_exists($models_name)){

										$models = new $models_name;

										exit;

									}elseif(method_exists($call_class, splice(2))){

										$func_name = splice(2);

										try{
											$call_class->$func_name();
										}
										catch(Throwable $e) {
											$this->notfound();
										}

										exit;

									}else{

										$this->notfound();
										exit;
									}

								}elseif(method_exists($call_class, splice(2))){

									$func_name = splice(2);

									try{
										$call_class->$func_name();
									}
									catch(Throwable $e) {
										$this->notfound();
									}

									if(class_exists($func_name))
									(new $func_name());

									exit;

								}else{

									$this->notfound();
									exit;
								}

							}elseif(method_exists($call_class, "home")){
							
								$call_class->home();

							}else{

								$this->notfound();
								exit;

							}

							echo $ob;

				    		exit;

						}else{

							$this->notfound();
							exit;
							
						}
					}
				}

			}else{


			//url found but target not found

				$default = (new routes)->load_controller()["default_controller"];

				$path = SERVER."/application/controllers/".$default.".php";

				if(file_exists(DirSeparator($path))){	
    			
	    			set_error_handler("handleError");
	    			
	    			register_shutdown_function('ShutDown');
	    		
		            require_once(DirSeparator($path));

		            ob_start();

		            $def_class = $default;

		            if(class_exists($def_class)) 
		            $call_class = new $def_class();

		        	else{
		        		$this->notfound();
		        		exit;
		        	}

		            $ob = ob_get_clean();			



					if(!empty(splice(1))){

						$models_path = SERVER."/application/models/".$default."/".splice(1).".php";

						if(file_exists($models_path)){

							require_once($models_path);

							$models_name = splice(1);

							if(class_exists($models_name)){

								$models = new $models_name;

								exit;

							}elseif(method_exists($call_class, splice(1))){

								$func_name = splice(1);

								try{
									$call_class->$func_name();
								}
								catch(Throwable $e) {
									$this->notfound();
								}

								exit;

							}else{

								$this->notfound();
								exit;
							}

						}elseif(method_exists($call_class, splice(1))){

							$func_name = splice(1);

							try{
								$call_class->$func_name();
							}
							catch(Throwable $e) {
								$this->notfound();
							}

							if(class_exists($func_name))
							(new $func_name());

							exit;

						}else{

							if(method_exists($call_class,"default"))
								$call_class->default();
							else
								$this->notfound();

							exit;
						}

					}elseif(method_exists($call_class, "home")){
					
						$call_class->home();

					}else{

						$this->notfound();
						exit;

					}

					echo $ob;

		    		exit;

				}else{

					$this->notfound();
					exit;
					
				}

			

			exit;

				
			}

		}else{
			
			// set default target

			$default = (new routes)->load_controller()["default_controller"];

			$path = SERVER."/application/controllers/".$default.".php";

			if(file_exists(DirSeparator($path))){	
		    			
    			set_error_handler("handleError");
    			
    			register_shutdown_function('ShutDown');
    		
	            require_once(DirSeparator($path));

	            ob_start();

	            $def_class = $default;

	            if(class_exists($def_class))
	            $call_class = new $def_class();

	        	else{
	        		$this->notfound();
	        		exit;
	        	}

	            $ob = ob_get_clean();			



				if(!empty(splice(1))){

					$models_path = SERVER."/application/models/".$default."/".splice(1).".php";

					if(file_exists($models_path)){

						require_once($models_path);

						$models_name = splice(1);

						if(class_exists($models_name)){

							$models = new $models_name;

							exit;

						}elseif(method_exists($call_class, splice(1))){

							$func_name = splice(1);

							try{
								$call_class->$func_name();
							}
							catch(Throwable $e) {
								$this->notfound();
							}

							exit;

						}else{

							$this->notfound();
							exit;
						}

					}elseif(method_exists($call_class, splice(1))){

						$func_name = splice(1);

						try{
							$call_class->$func_name();
						}
						catch(Throwable $e) {
							$this->notfound();
						}

						exit;

					}else{

						$this->notfound();
						exit;
					}

				}elseif(method_exists($call_class, "home")){
				
					$call_class->home();

				}else{

					$this->notfound();
					exit;

				}

				echo $ob;

	    		exit;

			}else{

				require_once(SERVER."/content/mugencode.php");	

				exit;
				
			}
			
		}
	}


	function notfound(){

		set_error_handler("handleError");
    			
		register_shutdown_function('ShutDown');

		require_once(SERVER."/404.php");

	}

}

