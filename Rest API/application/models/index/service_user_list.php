<?php
	
	class service_user_list extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$keyword = clean_xss_string($this->get("q"));

			$query = $this->db_select("data_user",[
				"%id" => $keyword,
				"%fullname" => $keyword,
				"%email" => $keyword,
			]);

			echo json_encode($query);

		}
	}