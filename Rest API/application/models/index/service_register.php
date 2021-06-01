<?php

	class service_register extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$build["response"] = false;
			$build["message"] = "Mohon lengkapi data dengan benar";

			$param_allow = ["fullname", "email", "phone", "province", "city", "password", "repassword"];

			if (is_array($this->post()))
			{

				// filtering data kosong
				foreach ($this->post() as $key => $val)
				{

					if (!in_array($key, $param_allow))
					{
						$build["response"] = false;
						$build["message"] = "Invalid paramater.";
						echo json_encode($build);
						exit;
					}

					$post[$key] = trim(clean_xss_string($val));

					if (empty($post[$key]))
					{
						$build["response"] = false;
						$build["message"] = "Mohon lengkapi data dengan benar";
						echo json_encode($build);
						exit;
					}
				}

				// validasi email
				$email = explode("@", $post["email"]);

				if (!isset($email[1]))
				{
					$build["response"] = false;
					$build["message"] = "Format email tidak sesuai.";
					echo json_encode($build);
					exit;
				}

				$email = explode(".", $email[1]);

				if (!isset($email[1]))
				{
					$build["response"] = false;
					$build["message"] = "Format email tidak sesuai.";
					echo json_encode($build);
					exit;
				}

				// validasi password
				if (strlen($post["password"]) < 6)
				{
					$build["response"] = false;
					$build["message"] = "Password minimal harus 6 karakter.";
					echo json_encode($build);
					exit;
				}

				// validasi nomor handphone
				if (strlen($post["phone"]) < 11 or strlen($post["phone"]) > 13  or !is_numeric($post["phone"]))
				{
					$build["response"] = false;
					$build["message"] = "Nomor telephone tidak valid.";
					echo json_encode($build);
					exit;
				}

				$query = $this->db_select("data_user", ["email" => $post["email"]]);

				if ($query->total_data == 0)
				{
					$password = md5($post["password"]);
					$repassword = md5($post["repassword"]);

					if ($password !== $repassword)
					{
						$build["response"] = false;
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
						$build["message"] = "Pendaftaran Berhasil";
					}
				} 
				else
				{
					$build["response"] = false;
					$build["message"] = "Email sudah terdaftar";
				}
			}

			echo json_encode($build);
		}
	}