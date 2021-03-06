<?php

    class index extends load
    {        

        public function __construct()
        {

            $ignore = ["service_login", "service_register", "service_location"];

            if (!in_array(splice(1), $ignore))
            {
                if (token($this->get("token")) !== false)
                {
                    header_content_type("json");

                    $token = token($this->get("token"));
                    $query = $this->db_select("data_token", ["token" => $token]);

                    if ($query->total_data > 0)
                    {
                        if ($query->status == 1)
                        {
                            if (time() > $query->end_date)
                            {
                                $this->db_update("data_token", ["status" => 0, "where-token" => $token]);

                                $json["response"] = false;
                                $json["message"] = "Token Expired.";

                                echo json_encode($json);
                                exit;
                            }
                        }

                        if ($query->status == 0)
                        {
                            $json["response"] = false;
                            $json["message"] = "Token Expired.";

                            echo json_encode($json);
                            exit;
                        }
                    }
                    else
                    {
                        $json["response"] = false;
                        $json["message"] = "Token Expired.";

                        echo json_encode($json);
                        exit;
                    }
                }
            }
        }

        public function home()
        {
            header_content_type("json");

            $json["response"] = false;
            $json["message"] = "Token Expired.";

            echo json_encode($json);
        }
    }
