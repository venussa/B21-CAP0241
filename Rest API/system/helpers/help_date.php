<?php

if(!function_exists("dateStamp")){

	/**
	 * Date Stamp
	 *
	 * Set deafult date or time stamp Value
	 *
	 * @param	array
	 * @param	Int
	 * @return	array
	 */

	function dateStamp(){

		return json_decode(json_encode(array(
		
			'year' 	=> 31556926, 
			'month' => 2629744, 
			'week'	=> 604800, 
			'day' 	=> 86400, 
			'hour' 	=> 3600, 
			'minute'=> 60
		)));

	}

}

if(!function_exists("timeHistory")){

	/**
	 * TImehistory
	 *
	 * TIme count Down System
	 *
	 * @param	Int
	 * @return	String
	 */

	function timeHistory($timestamp = null,$option = false,$get_result = null){
            
		if(empty($timestamp)){

			$timestamp = time();

		}

        $timestamp      = (int) $timestamp;
        $current_time   = time();
        $diff           = $current_time - $timestamp;

        if($option == false){
	       
	        if ($diff == 0)
	        {
	            return 'just now';
	        } 

	        if ($diff < 60)
	        {
	            return $diff == 1 ? $diff . ' just now' : $diff . ' second ago';
	        }      


	        if ($diff >= 60 && $diff < dateStamp()->hour)
	        {
	            $diff = floor($diff/dateStamp()->minute);
	            return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
	        }  


	        if ($diff >= dateStamp()->hour && $diff < dateStamp()->day)
	        {
	            $diff = floor($diff/dateStamp()->hour);
	            return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago ';
	        }   


	        if ($diff >= dateStamp()->day && $diff < dateStamp()->week)
	        {
	            $diff = floor($diff/dateStamp()->day);
	            return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
	        }   


	        if ($diff >= dateStamp()->week && $diff < dateStamp()->month)
	        {
	            $diff = floor($diff/dateStamp()->week);
	            return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
	        }   


	        if ($diff >= dateStamp()->month && $diff < dateStamp()->year)
	        {
	            $diff = floor($diff/dateStamp()->month);
	            return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
	        }   


	        if ($diff >= dateStamp()->year)
	        {
	            $diff = floor($diff/dateStamp()->year);
	            return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
	        }

	    }else{

	    	switch($get_result){

	    		case "second":

	    			return $diff;

	    		break;

	    		case "minute":

	    			return floor($diff/dateStamp()->minute);

	    		break;

	    		case "hour":

	    			return floor($diff/dateStamp()->hour);

	    		break;

	    		case "day":

	    			return floor($diff/dateStamp()->day);

	    		break;

	    		case "week":

	    			return floor($diff/dateStamp()->week);

	    		break;

	    		case "month":

	    			return floor($diff/dateStamp()->month);

	    		break;

	    		case "year":

	    			return floor($diff/dateStamp()->year);

	    		break;
	    	}


	    }
    }

}

if(!function_exists("monthConvert")){

	/**
	 * TIme converter
	 *
	 * Conver month as Int or As String
	 *
	 * @param	Mixed
	 * @return	mixed
	 */

	function monthConvert($date,$act = null){

		$date = strtolower($date);

		$data = array(

			1 => array("january","jan"),
			2 => array("february","feb"),
			3 => array("march","mar"),
			4 => array("april","apr"),
			5 => array("may","may"),
			6 => array("june","jun"),
			7 => array("july","jul"),
			8 => array("august","aug"),
			9 => array("september","sep"),
			10 => array("october","oct"),
			11 => array("november","nov"),
			12 => array("december","dec"),

		);

		$args = $date;

		if(!is_numeric($date)){

			foreach($data as $key => $val){

				$args = preg_replace(
				
					"/".implode("|",$val)."/",
					$key,
					$args

				);

			}

			return $args;

		}else{

			for($i = count($data) ; $i > 0; $i --){

				if($act == 1){

					$args = str_replace($i,$data[$i][1],$args);

				}else{

					$args = str_replace($i,$data[$i][0],$args);

				}

			}

			return $args;

		}

	}

}

if(!function_exists("secondsToTime")){

	/**
	 * TIme converter
	 *
	 * Conver second to other time
	 *
	 * @param	Mixed
	 * @return	mixed
	 */

	function secondsToTime($inputSeconds) {
	    $secondsInAMinute = 60;
	    $secondsInAnHour = 60 * $secondsInAMinute;
	    $secondsInADay = 24 * $secondsInAnHour;

	    // Extract days
	    $days = floor($inputSeconds / $secondsInADay);

	    // Extract hours
	    $hourSeconds = $inputSeconds % $secondsInADay;
	    $hours = floor($hourSeconds / $secondsInAnHour);

	    // Extract minutes
	    $minuteSeconds = $hourSeconds % $secondsInAnHour;
	    $minutes = floor($minuteSeconds / $secondsInAMinute);

	    // Extract the remaining seconds
	    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
	    $seconds = ceil($remainingSeconds);

	    // Format and return
	    $timeParts = [];
	    $sections = [
	        'day' => (int)$days,
	        'hour' => (int)$hours,
	        'minute' => (int)$minutes,
	        'second' => (int)$seconds,
	    ];

	    // foreach ($sections as $name => $value){
	    //     if ($value > 0){
	    //         $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
	    //     }
	    // }

	    return $sections;
	}

}