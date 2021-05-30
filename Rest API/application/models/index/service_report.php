<?php
	class service_report extends load 
	{ 
		public function __construct()
		{       

			header_content_type("json");

			if (is_array($this->post()))
			{
				foreach ($this->post() as $key => $value) {
					
					$post[$key] = trim(clean_xss_string($value));

					if (empty($post[$key]))
					{
						$build["response"] = false;
						$build["code"] = 0;
						$build["message"] = "Mohon Lengkapi Seluruh data.";			

						echo json_encode($build);
						exit;
					}
				}

				$build["response"] = true;
				$build["code"] = 1;
				$build["message"] = "Laporan berhasil dikirim.";
				$post["datetime"] = date("Y-m-d H:i:s", time());
				$post["timestamp"] = time();

				$this->db_insert("data_process", $post);
			}
			else
			{
				$build["response"] = false;
				$build["code"] = 0;
				$build["message"] = "Mohon Lengkapi Seluruh data.";
			}

			echo json_encode($build);
		}
	}
