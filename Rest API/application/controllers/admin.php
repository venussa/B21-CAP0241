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
			else
			{
				if (!isset($_SESSION["token"]))
				{
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
			$this->is_admin();
			$this->view("admin/report");
		}

		public function log_prediction()
		{
			$this->is_admin();
			$this->view("admin/log_prediction");
		}

		public function users()
		{
			$this->is_admin();
			$this->view("admin/users");
		}

		protected function is_admin()
		{
			if (isset($_SESSION["token"]))
			{
				$query = json_decode(Curl(HomeUrl()."/service_my_data?token=".$_SESSION["token"]));

				if ($query->data->role !== "admin" or $query->response == false)
				{
					session_destroy();
					header("location:".HomeUrl()."/admin/login");	
				}
			}
		}
	}