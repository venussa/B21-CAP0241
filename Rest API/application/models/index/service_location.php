<?php

 	class service_location extends load
 	{
 		public function __construct()
 		{
 			header_content_type("json");

 			$data = provinsi();

 			$index = 0;

 			$build["response"] = true;
 			$build["message"] = "Data didapatkan.";

 			$keyword = clean_xss_string($this->get("q"));

 			$action = false; 

 			if (!empty($keyword))
 			{
 				$action = true;
 			}

 			foreach($data as $key => $value)
 			{
 				if (
 					($action == true and strpos(" ".strtolower($value), strtolower($keyword))) or 
 					empty($keyword) or 
 					($keyword == ("p".($index + 1)))
 				)
 				{
	 				$build["data"][$index]["province_id"] = "p".($index + 1);
	 				$build["data"][$index]["province_name"] = $value;

	 				foreach(kabupaten() as $ke1y1 => $value1)
	 				{
	 					$build["data"][$index]["city"][] = $value1;
	 				}
	 			}

	 			$index++;
 			}

 			if (!isset($build["data"]))
 			{
 				$build["response"] = false;
 				$build["message"] = "Data tidak ditemukan.";
 			}

 			echo json_encode($build);		
 		} 
 	}