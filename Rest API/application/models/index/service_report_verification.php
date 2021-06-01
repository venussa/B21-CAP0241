<?php
	
	class service_report_verification extends load
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

			if (empty($this->post("status")))
			{
				$build["response"] = false;
				$build["message"] = "Data gagal di simpan";

			}
			else
			{

				$status = (int) clean_xss_string($this->post("status"));
				$process_token = process_token();

				$this->db_update("data_report", [
					"status" => $status,
					"where-process_token" => $process_token,
				]);

				$build["response"] = true;
				$build["message"] = "Data berhasil di simpan";
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

			$query = $this->db_select("data_user", ["email" => $query->email, "role" => "admin"]);


			if ($query->total_data == 0)
			{
				return false;
			}

			return true;
		}
	}
