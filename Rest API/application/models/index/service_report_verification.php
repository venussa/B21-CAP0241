<?php
	
	class service_report_verification extends load
	{
		public function __construct()
		{

			header_content_type("json");

			if (empty($this->post("status")))
			{
				$build["response"] = false;
				$build["message"] = "Data gagal di simpan";

			}
			else
			{

				$status = (int) clean_xss_string($this->post("status"));
				$id = clean_xss_string($this->post("id"));

				$this->db_update("data_process", [
					"status" => $status,
					"where-id" => $id,
				]);

				$build["response"] = true;
				$build["message"] = "Data berhasil di simpan";
			}

			echo json_encode($build);
		}
	}
