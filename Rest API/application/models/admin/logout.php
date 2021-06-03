<?php

	class logout extends load
	{
		public function __construct()
		{
			session_destroy();
			header("location:".HomeUrl()."/admin/login");
		}
	}