<?php

namespace system\core;

use system\core\database;

/**
 * database_select Class
 *
 * Query access for select data from MySQL database
 * usinjg PDO Driver Extention
 *
 * @package		system
 * @subpackage	core
 * @category	Database Query
 * @throws 		\DBQuery On call Query
 */

	class database_select{

		/**
	    * Initial database name
	    *
	    * @var  string
	    */
		var $database;

		/**
	    * Condition & value
	    *
	    * @var  array
	    */
		var $paramater;

		/**
	    * Select Order
	    *
	    * @var  string
	    */
		var $order;

		/**
	    * Limit result of data
	    *
	    * @var  string
	    */
		var $limit;

		/**
	    * offset result of data
	    *
	    * @var  string
	    */
		var $ofset;

		// --------------------------------------------------------------------

	    /**
	     * Constructor Defauult Access
	     *
	     * @return string
	     */

		function __construct($database, $paramater = array()){

			$this->database = $database;

			$this->paramater = $paramater;

			$option = $this->strToArray();

			$this->limit = (int) $option["limit"];
			$this->limit = ($this->limit < 1) ? 10 : $this->limit;

			$this->page = (int) $option["page"];
			$this->page = ($this->page < 1) ? 1 : $this->page;

			$this->offset = ($this->page - 1) * $this->limit;

			$this->limit = "LIMIT $this->offset, $this->limit";

			if(!empty($option["order_by"]) and !empty($option["sort_by"]))
				$this->order = "ORDER BY ".clean_xss_string($option["order_by"])." "
				.clean_xss_string($option["sort_by"]);

			$this->database = $option["database"];

		}

		// --------------------------------------------------------------------

	    /**
	     * query builder
	     *
	     * @return string
	     */

		function strToArray(){

			$url_components = parse_url($this->database); 

			$params = [];

			if(isset($url_components['query']))
				
				parse_str($url_components['query'], $params); 

			$build["database"] = $url_components["path"];
			$build["order_by"] = (isset($params["order_by"])) ? $params["order_by"] : null;
			$build["sort_by"] = (isset($params["sort_by"])) ? $params["sort_by"] : null;
			$build["page"] = (isset($params["page"])) ? $params["page"] : null;
			$build["limit"] = (isset($params["limit"])) ? $params["limit"] : null;
				
			return $build;

		}

		// --------------------------------------------------------------------

	    /**
	     * Error Handler
	     *
	     * @return mixed
	     */

		function catch_error(){

			try{

				$this->main_query();

				$query = $this->main_query();

				$index = 0;

				$build = [];
				$build["total_data"] = $this->count_total_data();
				$build["total_data_this_page"] = $query->rowCount();
				$build["response"] = ($build["total_data"] == 0) ? false : true;

				while($show = $query->fetch()){

					if($index == 0) $general = $show;

					$build[] = $this->build_data_as_json($show);

					$index++;

				}

				if(isset($general)) {

					$general = $this->build_data_as_json($general);
					$build = array_merge($build, $general);

				}

				return json_decode(json_encode($build));

			}catch(Exception $e){

				return false;

			}

		}

		// --------------------------------------------------------------------

	    /**
	     * Query builder
	     *
	     * @return string
	     */

		function query_command(){

			$query = $this->paramater;

			foreach($query as $key => $val){

				$replace = [">=","<=",">","<","%%","%","!"," "];

				$key_index = str_replace($replace,null, $key);

					if(strpos(" ".$key, "%%"))

						$build1[] = $key_index." = '".$val."'";

					elseif(strpos(" ".$key, "%"))

						$build1[] = $key_index." like '%".$val."%'";

					elseif(strpos(" ".$key, ">="))
				
						$build2[] = $key_index." >= ".clean_xss_string($val);

					elseif(strpos(" ".$key, "<="))
				
						$build2[] = $key_index." <= ".clean_xss_string($val);

					elseif(strpos(" ".$key, ">"))
				
						$build2[] = $key_index." > ".clean_xss_string($val);

					elseif(strpos(" ".$key, "<"))
				
						$build2[] = $key_index." < ".clean_xss_string($val);

					elseif(strpos(" ".$key, "!"))
				
						$build2[] = $key_index." != '".clean_xss_string($val)."'";

					else
						$build2[] = $key_index." = '".clean_xss_string($val)."'";
					

			}

			if((isset($build1)) and (isset($build2)))

				$paramater = " WHERE (".implode(" or ", $build1).") and ".implode(" and ", $build2);

			elseif((isset($build1)) and (!isset($build2)))

				$paramater = " WHERE (".implode(" or ", $build1).")";

			elseif((!isset($build1)) and (isset($build2)))

				$paramater = " WHERE ".implode(" and ", $build2);

			else $paramater = null;

			return "SELECT * FROM ".$this->database." ".$paramater;
			

		}

		// --------------------------------------------------------------------

	    /**
	     * Count total result of data
	     *
	     * @return void
	     */

		function count_total_data(){

			$query = (new database)->query($this->query_command());	

			return $query->rowCount();
		}

		// --------------------------------------------------------------------

	    /**
	     * Query Executor
	     *
	     * @return void
	     */

		function main_query(){		

			return (new database)->query($this->query_command()." ".$this->order." ".$this->limit);		
		}

		// --------------------------------------------------------------------

	    /**
	     * Build result as json
	     *
	     * @return void
	     */

		function build_data_as_json($show){

			foreach ($show as $key => $value) {
				
				if(!is_numeric($key))
					$tmp_data[$key] = $value;

			}

			return $tmp_data;

		}

	}