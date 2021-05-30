<?php

	class service_edit_user extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$build["response"] = false;
			$build["code"] = 0;
			$build["message"] = "Mohon lengkapi data dengan benar";

			if (is_array($this->post()))
			{
				foreach ($this->post() as $key => $val)
				{
					$post[$key] = trim(clean_xss_string($val));

					if (empty($post[$key]))
					{
						$build["response"] = false;
						$build["code"] = 0;
						$build["message"] = "Mohon lengkapi data dengan benar";
						echo json_encode($build);
						exit;
					}
				}

				$query = $this->db_select("data_user", ["email" => $post["email"]]);

				if ($query->total_data == 1)
				{
					$oldpassword = md5($post["oldpassword"]);
					$password = md5($post["password"]);
					$repassword = md5($post["repassword"]);

					if ($oldpassword == $query->password)
					{
						if ($password !== $repassword)
						{
							$build["response"] = false;
							$build["code"] = 2;
							$build["message"] = "Password tidak cocok";
						}
						else
						{
							
							$query_param = $post;
							unset($query_param["email"]);
							unset($query_param["oldpassword"]);
							unset($query_param["repassword"]);

							$query_param["password"] = $password;

							$query_param["where-email"] = $post["email"];

							$this->db_update("data_user", $query_param);

							$build["response"] = true;
							$build["code"] = 3;
							$build["message"] = "Data berhasil ditubah";
						}
					}
					else
					{
						$build["response"] = false;
						$build["code"] = 1;
						$build["message"] = "Password lama salah";
					}
				} 
			}

			echo json_encode($build);
		}
	}