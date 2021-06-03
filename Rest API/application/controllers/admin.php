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
			$this->view("admin/report");
		}
	}