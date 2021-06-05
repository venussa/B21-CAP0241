<?php
	
	class service_my_data extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			// validate token
			if ($this->validate_token() == false)
			{
				$build["response"] = false;
				$build["message"] = "Token Expired.";
				echo json_encode($build);
				exit;
			}

			$token = token($this->get("token"));

			$query = $this->db_select("data_token", ["token" => $token]);
			$query = $this->db_select("data_user",["email" => $query->email]);
			$email = $query->email;
			
			if ($query->total_data > 0)
			{

				$build["response"] = true;
				$build["message"] = "Data berhasil di dapatkan";

				foreach ($query as $key => $value)
				{
					if (is_numeric($key))
					{
						foreach ($value as $key1 => $value1)
						{
							$build["data"][$key1] = $value1;
						}

						unset($build["data"]["password"]);
						$log_time = $this->db_select("data_token", ["token" => $token]);
						$build["data"]["login_time"] = date("Y-m-d H:i:s", $log_time->login_time);
						$build["data"]["id"] = (int) $build["data"]["id"];
						$build["data"]["photo"] = HomeUrl()."/".$build["data"]["photo"];
						$build["data"]["register_time"] = date("Y-m-d H:i:s", $build["data"]["register_time"]);
					}
				}

				$report = $this->db_select("data_report", [
					"email" => $email
				]);

				$build["data"]["log_report"] = [];

				if ($report->total_data > 0)
	            {
	                foreach ($report as $key => $value)
	                {
	                    if (is_numeric($key))
	                    {
	                    	$value->datetime = date("Y-m-d H:i:s", $value->timestamp);
	                    	unset($value->timestamp);
	                    	$value->id = (int) $value->id;
	                    	$value->image = HomeUrl()."/".$value->urlimage;
	                    	$value->status = (int) $value->status;
	                    	$value->verified_timestamp = ($value->verified_timestamp == 0) ? "-" : date("Y-m-d H:i:s", $value->verified_timestamp);
	                    	unset($value->urlimage);
	                        $build["data"]["log_report"][] = $value;
	                    }
	                }
	            }
			}
			else
			{
				$build["response"] = false;
				$build["message"] = "Data tidak ditemukan";
			}

			echo json_encode($build);

		}

		protected function validate_token()
		{
			$token = token($this->get("token"));

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
