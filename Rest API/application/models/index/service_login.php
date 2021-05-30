<?php

	class service_login extends load
	{
		public function __construct()
		{
			header_content_type("json");

			$email = clean_xss_string($this->post("email"));
			$pass  = md5(clean_xss_string($this->post("password"))); 

			$query = $this->db_select("data_user", ["email" => $email]);

			$build["response"] = false;
			$build["code"] = 0;
			$build["message"] = "Mohon lengkapi data dengan benar";

			if (!empty($email) and !empty($pass))
			{
				if ($query->total_data > 0)
				{
					if ($query->password == $pass)
					{
						$build["response"] = true;
						$build["code"] = 3;
						$build["message"] = "Login berhasil.";

						foreach($query as $key => $val)
						{
							if (is_numeric($key))
							{
								foreach ($val as $index => $data)
								{
									$build["data"][$index] = $data;
								}
							}
						}
					}
					else
					{
						$build["response"] = false;
						$build["code"] = 1;
						$build["message"] = "Password anda salah.";
					}
				}
				else
				{
					$build["response"] = false;
					$build["code"] = 2;
					$build["message"] = "Email tidak terdaftar.";
				}
			}

			echo json_encode($build);
		}
	}