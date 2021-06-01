<?php
	
	class service_log_report extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			// validate token
			if ($this->validate_token() == false)
			{
				$build["response"] = false;
				$build["message"] = "Token Expired";
				echo json_encode($build);
				exit;
			}

			$keyword = clean_xss_string($this->get("q"));

			$page = (int) $this->get("page");
            $limit = (int) $this->get("limit");

            $page = ($page < 1) ? 1 : $page;
            $limit = ($limit < 1) ? 1 : $limit;

			$query = $this->db_select("data_report?page=$page&limit=$limit",[
				"%fullname" => $keyword,
				"%email" => $keyword,
				"%scan_type" => $keyword,
				"%address" => $keyword,
				"%buildtype" => $keyword,
				"%damage_lvl" => $keyword,
				"%process_token" => $keyword
			]);

	        $build["response"] = true;
	        $build["message"] = "Data Berhasil didapatkan.";
                    
            if ($query->total_data > 0)
            {
                foreach ($query as $key => $value)
                {
                    if (is_numeric($key))
                    {
                    	$value->date_time = date("Y-m-d H:i:s", $value->timestamp);
                    	unset($value->timestamp);
                    	$value->id = (int) $value->id;
                    	$value->image = HomeUrl()."/".$value->urlimage;
                    	$value->status = (int) $value->status;
                    	unset($value->urlimage);
                        $build["data"][] = $value;
                    }
                }
            }
            else
            {
                $build["response"] = false;
                $build["message"] = "Data tidak ditemukan.";
            }

            echo json_encode($build);

		}

		protected function validate_token()
		{
			$token = token();

			$query = $this->db_select("data_token", [
				"token" => $token,
				"status" => 1,
				"start_date<" => time(),
				"end_date>" => time(), 
			]);

			if ($query->total_data == 0)
			{
				return false;
			}

			return true;
		}


	}
