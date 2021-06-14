<?php

	class admin extends load
	{
		public function __construct()
		{
			if (splice(2) == "login")
			{
				if (isset($_SESSION["token"]))
				{
					header("location:".HomeUrl()."/admin/report");	
				}
			}
			else if ((splice(2) !== "token") and (splice(2) !== "logout"))
			{
				$session = isset($_SESSION["token"]) ? $_SESSION["token"] : null;
				
				$query = json_decode(Curl(HomeUrl()."/service_my_data?token=".$session));

				if ($query->response == false) 
				{
					session_destroy();
					header("location:".HomeUrl()."/admin/login");
				}

				if ($query->data->role !== "admin")
                { 
                        session_destroy();
                        header("location:".HomeUrl()."/admin/login");
                }
			}
		}

		public function home()
		{
			header("location:".HomeUrl()."/admin/login");	
		}

		public function login()
		{
			$this->view("admin/login");
		}

		public function report()
		{
			$this->view("admin/report");
		}

		public function log_prediction()
		{
			$this->view("admin/log_prediction");
		}

		public function users()
		{
			$this->view("admin/users");
		}
	}