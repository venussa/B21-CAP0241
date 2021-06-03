<?php

	class token extends load
	{
		public function __construct()
		{
			$_SESSION["token"] = clean_xss_string($this->get("access_token"));
		}
	}