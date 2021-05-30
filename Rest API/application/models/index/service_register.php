<?php

	class service_register extends load 
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

				if ($query->total_data == 0)
				{
					$password = md5($post["password"]);
					$repassword = md5($post["repassword"]);

					if ($password !== $repassword)
					{
						$build["response"] = false;
						$build["code"] = 2;
						$build["message"] = "Password tidak cocok";
					}
					else
					{
						unset($post["repassword"]);

						$post["register_time"] = time();
						$post["password"] = $password;
						$post["role"] = "user";

						$this->db_insert("data_user", $post);

						$build["response"] = true;
						$build["code"] = 3;
						$build["message"] = "Pendaftaran Berhasil";
					}
				} 
				else
				{
					$build["response"] = false;
					$build["code"] = 1;
					$build["message"] = "Email sudah terdaftar";
				}
			}

			echo json_encode($build);
		}
	}