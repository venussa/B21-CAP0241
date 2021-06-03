<?php
	
	class service_edit_user extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$build["response"] = false;
			$build["message"] = "Mohon lengkapi data dengan benar";

			$param_allow = ["fullname", "phone", "province", "city", "oldpassword", "password", "repassword"];
			$param_ignore = ["oldpassword", "password", "repassword"];

			// validate token
			if ($this->validate_token() == false)
			{
				$build["response"] = false;
				$build["message"] = "Token Expired.";
				echo json_encode($build);
				exit;
			}

			$token = token($this->get("token"));
			$query = $this->db_select("data_token", ["token" => $token]);

			if (is_array($this->post()))
			{
				foreach ($this->post() as $key => $val)
				{

					// validate param
					if (!in_array($key, $param_allow))
					{
						$build["response"] = false;
						$build["message"] = "Invalid paramater.";
						echo json_encode($build);
						exit;
					}

					
					$post[$key] = trim(clean_xss_string($val));

					if (empty($post[$key]) and !in_array($key, $param_ignore))
					{
						$build["response"] = false;
						$build["message"] = "Mohon lengkapi data dengan benar";
						echo json_encode($build);
						exit;
					}
				}


				// validasi nomor handphone
				if (strlen($post["phone"]) < 11 or strlen($post["phone"]) > 13  or !is_numeric($post["phone"]))
				{
					$build["response"] = false;
					$build["message"] = "Nomor telephone tidak valid.";
					echo json_encode($build);
					exit;
				}

				// validasi upload photo
				if (!empty($_FILES["photo"]["name"]))
				{
					$file = $_FILES["photo"];
					$allow_ext = ["jpg", "jpeg", "png"];
					$ext = get_extention($file["name"]);
					$name = "profile-".md5($query->email).".".$ext;
					$path = "upload/".$name;

					if (in_array($ext, $allow_ext))
					{
						if (move_uploaded_file($file["tmp_name"], SERVER."/".$path))
						{
							$photo = $path;
						}
						else
						{
							$build["response"] = false;
							$build["message"] = "Gagal merubah foto.";
							echo json_encode($build);
							exit;
						}
					}
					else
					{
						$build["response"] = false;
						$build["message"] = "Gagal merubah foto.";
						echo json_encode($build);
						exit;
					}
				}

				$query = $this->db_select("data_user", ["email" => $query->email]);

				if ($query->total_data == 1)
				{
					if (!empty($post["oldpassword"]) and !empty($post["password"]) and !empty($post["repassword"]))
					{
						$oldpassword = md5($post["oldpassword"]);
						$password = md5($post["password"]);
						$repassword = md5($post["repassword"]);

						if ($oldpassword == $query->password)
						{
							if ($password !== $repassword)
							{
								$build["response"] = false;
								$build["message"] = "Password tidak cocok";
								echo json_encode($build);
								exit;
							}
							else
							{
								$new_password = true;
							}
						}
						else
						{
							$build["response"] = false;
							$build["message"] = "Password lama salah";
							echo json_encode($build);
							exit;
						}
					}


					$query_param = $post;
					unset($query_param["oldpassword"]);
					unset($query_param["repassword"]);
					unset($query_param["password"]);
					unset($query_param["photo"]);

					if (isset($new_password))
					{
						$query_param["password"] = $password;
					}

					if (isset($photo))
					{
						$query_param["photo"] = $photo;
					}

					$query_param["where-email"] = $query->email;

					$this->db_update("data_user", $query_param);

					$build["response"] = true;
					$build["message"] = "Data berhasil dirubah.";
				} 
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