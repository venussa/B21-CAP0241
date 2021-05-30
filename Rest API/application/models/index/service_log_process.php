<?php
	
	class service_log_process extends load 
	{
		public function __construct()
		{
			header_content_type("json");

			$keyword = clean_xss_string($this->get("q"));

			$page = (int) $this->get("page");
                        $limit = (int) $this->get("limit");

                        $page = ($page < 1) ? 1 : $page;
                        $limit = ($limit < 1) ? 1 : $limit;

			$query = $this->db_select("data_process?page=$page&limit=$limit",[
				"%email" => $keyword,
				"%buildtype" => $keyword,
				"%address" => $keyword,
				"%damage_lvl" => $keyword,
				"%datetime" => $keyword,
			]);

		        $build["response"] = true;
                        
                        if ($query->total_data > 0)
                        {
                                foreach ($query as $key => $value)
                                {
                                        if (is_numeric($key))
                                        {
                                                $build["data"][] = $value;
                                        }
                                }
                        }
                        else
                        {
                                $build["response"] = false;
                        }

                        echo json_encode($build);

		}
	}
