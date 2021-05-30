<?php
	
	class service_log_process extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$keyword = clean_xss_string($this->get("q"));

			$query = $this->db_select("data_process",[
				"%email" => $keyword,
				"%buildtype" => $keyword,
				"%address" => $keyword,
				"%damage_lvl" => $keyword,
				"%datetime" => $keyword,
			]);

			echo json_encode($query);

		}
	}