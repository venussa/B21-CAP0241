<?php

	class token extends load
	{
		public function __construct()
		{
			header_content_type("json");

			$_SESSION["token"] = clean_xss_string($this->get("access_token"));

			echo json_encode($_SESSION);

		}
	}