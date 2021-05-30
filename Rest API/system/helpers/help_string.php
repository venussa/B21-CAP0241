<?php

use application\config\character;
use system\core\character_set;
use system\core\char_utf8;

if(!function_exists("wordLimit")){

	/**
	 * Limit Word
	 *
	 * Limit string as Word
	 *
	 * @param	string
	 * @return	string
	 */

	function wordLimit($text = null,$num = null){

		$text = explode(" ",$text);

		foreach ($text as $key => $value){

			if(($key + 1) <= $num){

				$result[] = $value;
				$counts[] = 1;

			}
		}

		if((array_sum($counts)) == ($num)){

			$result = implode(" ",$result)." ...";

		}else{

			$result = implode(" ",$result);

		}

		return $result;
	}

}

if(!function_exists("stringLimit")){

	/**
	 * Limit String
	 *
	 * @param	string
	 * @return	string
	 */

	function stringLimit($text = null,$limit = null,$holder = null){

		$count = strlen($text);

		if($count > $limit){

			return substr($text,0,$limit).$holder;

		}else{

			return substr($text,0,$limit);

		}

	}

}

if(!function_exists("special_str")){

	/**
	 * Limit String
	 *
	 * @uses 	character class
	 * @param	string
	 * @return	string
	 */

	function special_str($text = null){

		return (new character)->toLatin($text);

	}

}

if(!function_exists("is_md5")){

	/**
	 * Check Is MD% String
	 *
	 * @param	string
	 * @return	string
	 */

	function is_md5($md5 =''){

	    if(preg_match('/^[a-f0-9]{32}$/', $md5) == 1){

	    	return true;
	    	
	    }else{

	    	return false;
	    }

	}

}

if(!function_exists("convertToReadableSize")){

	/**
	 * Byte Converter Size
	 *
	 * @param	string
	 * @return	string
	 */

	function convertToReadableSize($size){
	 
		 $base = log($size) / log(1024);
		 $suffix = array(" Byte", " KB", " MB", " GB", " TB");
		 $f_base = floor($base);
		 $result = round(pow(1024, $base - floor($base)), 1);

		 if($base < 0) return "0 Byte";

		 else return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
	}

}

if(!function_exists("auto_typography")){

	/**
	 * Auto Typografi
	 *
	 * @param	string
	 * @return	string
	 */

	function auto_typography($str = null){

		return (new character_set)->auto_typography($str);

	}
}

if(!function_exists("format_characters")){

	/**
	 * Format character
	 *
	 * @param	string
	 * @return	string
	 */

	function format_characters($str = null){

		return (new character_set)->format_character($str);

	}
}

if(!function_exists("_format_newlines")){

	/**
	 * auto new lines
	 *
	 * @param	string
	 * @return	string
	 */

	function _format_newlines($str = null){

		return (new character_set)->_format_newlines($str);

	}
}

if(!function_exists("_protect_characters")){

	/**
	 * protect character
	 *
	 * @param	string
	 * @return	string
	 */

	function _protect_characters($str = null){

		return (new character_set)->_protect_characters($str);

	}
}

if(!function_exists("nl2br_except_pre")){

	/**
	 * nl2br except pre
	 *
	 * @param	string
	 * @return	string
	 */

	function nl2br_except_pre($str = null){

		return (new character_set)->nl2br_except_pre($str);

	}
}

if(!function_exists("is_acsii")){

	/**
	 * is ascii
	 *
	 * @param	string
	 * @return	bool
	 */

	function is_acsii($str = null){

		return (new char_utf8)->is_acsii($str);

	}
}

if(!function_exists("convert_to_utf8")){

	/**
	 * Convert UTF8
	 *
	 * @param	string
	 * @return	string
	 */

	function convert_to_utf8($str = null){

		return (new char_utf8)->convert_to_utf8($str);

	}
}

if(!function_exists("safe_ascii_for_xml")){

	/**
	 * Safe Ascii XML
	 *
	 * @param	string
	 * @return	string
	 */

	function safe_ascii_for_xml($str = null){

		return (new char_utf8)->safe_ascii_for_xml($str);

	}
}

if(!function_exists("clean_string")){

	/**
	 * Cleang Asci String
	 *
	 * @param	string
	 * @return	string
	 */

	function clean_string($str = null){

		return (new char_utf8)->clean_string($str);

	}
}

if(!function_exists("clean_xss_string")){

	/**
	 * Cleang Vulnarable String
	 *
	 * @param	string
	 * @return	string
	 */

	function clean_xss_string($str = null, $strip_tags = true){

		if($strip_tags == false)
		return urldecode(trim(str_replace(['<?','?>','"',"'"],['<--?','?-->','&quot;','&quot;'],$str)));
		else
		return urldecode(trim(strip_tags(str_replace(['<?','?>','"',"'"],['<--?','?-->','&quot;','&quot;'],$str))));

	}
}


if(!function_exists("html2bb")){

	/**
	 * Convert html to bbcode
	 *
	 * @param	string
	 * @return	string
	 */
	function html2bb($content){

	  return str_replace(["<",">"], ["[","]"], $content);

	}
}

if(!function_exists("bb2html")){

	/**
	 * Convert bbcode to html
	 *
	 * @param	string
	 * @return	string
	 */

	function bb2html($content){

	  return str_replace(["[","]"], ["<",">"], $content);

	}

}

if(!function_exists("currentTyping")){

	/**
	 * get data current typing
	 *
	 * @param	string
	 * @return	array
	 */

	function currentTyping($string = null){

		$splits = explode(" ", $string);

		$index = 0;

		$build["status"] = false;

		if(isset($_SESSION["cache_text"]) and is_array($_SESSION["cache_text"]))
		{
			$p1_length = count($splits);
			$p2_length = count($_SESSION["cache_text"]);

			if($p1_length >= $p2_length)
				
				foreach ($splits as $key => $value) 
				{
					if(isset($_SESSION["cache_text"][$key]))
					{
						if($_SESSION["cache_text"][$key] !== $value)
						{
							$build["update_pos"] = $key;

							$build["new_data"][] = $value;
							$build["status"] = true;
							
							break;
						}
					}
					else
					{
						if($index == 0)	$build["update_pos"] = $key;

						$build["new_data"][] = $value;
						$build["status"] = true;

						$index++;
					}
				}

			else unset($_SESSION["cache_text"]);
		}

		unset($_SESSION["cache_text"]);

		foreach($splits as $key => $value)
		{
			$_SESSION["cache_text"][] = $value;
		}

		return json_decode(json_encode($build));

	}
}