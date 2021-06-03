<?php
	
	class service_user_list extends load 
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
			$keyword = clean_xss_string($this->get("q"));
			$page = (int) $this->get("page");
			$limit = (int) $this->get("limit");

			$page = ($page < 1) ? 1 : $page;
			$limit = ($limit < 1) ? 1 : $limit;

			$query = $this->db_select("data_user?page=$page&limit=$limit",[
				"%id" => $keyword,
				"%fullname" => $keyword,
				"%email" => $keyword,
				"!role" => "admin",
			]);

			$build["response"] = true;
			$build["message"] = "Data berhasil di dapatkan";
			
			if ($query->total_data > 0)
			{
				foreach ($query as $key => $value)
				{
					if (is_numeric($key))
					{
						unset($value->password);
						$log_time = $this->db_select("data_token", ["token" => $token]);
						$value->login_time = date("Y-m-d H:i:s", $log_time->login_time);
						$value->id = (int) $value->id;
						$value->photo = HomeUrl()."/".$value->photo;
						$value->register_time = date("Y-m-d H:i:s", $value->register_time);
						$build["data"][] = $value;
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

			$query = $this->db_select("data_user", ["email" => $query->email, "role" => "admin"]);


			if ($query->total_data == 0)
			{
				return false;
			}

			return true;
		}
	}
