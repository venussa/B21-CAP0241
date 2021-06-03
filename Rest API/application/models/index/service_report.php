<?php
	class service_report extends load 
	{ 
		public function __construct()
		{       

			header_content_type("json");

			$param_allow = ["fullname","buildtype", "address", "geocordinate"];

			// validate token
			if ($this->validate_token() == false)
			{
				$build["response"] = false;
				$build["message"] = "Token Expired.";
				echo json_encode($build);
				exit;
			}


			if (is_array($this->post()))
			{
				foreach ($this->post() as $key => $value)
				{
					if (!in_array($key, $param_allow))
					{
						$build["response"] = false;
						$build["message"] = "Invalid paramater.".$key;
						echo json_encode($build);
						exit;
					}
					
					$post[$key] = trim(clean_xss_string($value));

					if (empty($post[$key]))
					{
						$build["response"] = false;
						$build["message"] = "Mohon Lengkapi Seluruh data.";			

						echo json_encode($build);
						exit;
					}
				}

				$query = $this->db_select("data_process", ["process_token" => process_token($this->get("process_token"))]);
				
				if ($query->total_data == 0)
				{
					$build["response"] = false;
					$build["message"] = "Tidak ditemukan catatan proses.";
					echo json_encode($build);
					exit;
				}

				$param["fullname"] = $post["fullname"];
				$param["email"] = $query->email;
				$param["urlimage"] = $query->image;
				$param["buildtype"] = $post["buildtype"];
				$param["scan_type"] = $query->scan_type;
				$param["address"] = $post["address"];
				$param["geocordinate"] = $post["geocordinate"];
				$param["damage_lvl"] = $query->damage_lvl;
				$param["datetime"] = date("Y-m-d H:i:s");
				$param["process_token"] = $query->process_token;
				$param["status"] = 0;
				$param["timestamp"] = time();


				$build["response"] = true;
				$build["message"] = "Laporan berhasil dikirim.";

				$this->db_insert("data_report", $param);
			}
			else
			{
				$build["response"] = false;
				$build["message"] = "Mohon Lengkapi Seluruh data.";
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
