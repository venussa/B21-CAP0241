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
			$build["message"] = "Username atau password belum terisi.";

			if (!empty($email) and !empty($pass))
			{
				if ($query->total_data > 0)
				{
					if ($query->password == $pass)
					{
						$build["response"] = true;
						$build["message"] = "Login Berhasil, Selamat datang.";

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

						unset($build["data"]["password"]);

						$build["data"]["login_time"] = date("Y-m-d H:i:s",time());
						$build["data"]["register_time"] = date("Y-m-d H:i:s", $build["data"]["register_time"]);
						$build["data"]["id"] = (int) $build["data"]["id"];
						$build["access_token"] = md5($build["data"]["email"].time());
						$build["expired"] = "2 Minggu";

						$this->db_update("data_token", [
							"status" => 0,
							"where-email" => $build["data"]["email"],
						]);

						$this->db_insert("data_token", [
							"email" => $build["data"]["email"],
							"token" => $build["access_token"],
							"start_date" => time(),
							"end_date" => (time() + (3600 * 24 * 14)),
							"status" => 1,
							"login_time" => time(),
						]);
					}
					else
					{
						$build["response"] = false;
						$build["message"] = "Username atau password salah.";
					}
				}
				else
				{
					$build["response"] = false;
					$build["message"] = "Username atau password salah.";
				}
			}

			echo json_encode($build);
		}
	}