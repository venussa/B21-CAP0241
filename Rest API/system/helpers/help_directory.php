<?php

if(!function_exists("scan_dir")){

	/**
	 * Scan Dr
	 *
	 * @param	String
	 * @return	array
	 */

	function scan_dir($path){

		$data = explode("/",$path);

		foreach($data as $key => $val){

			if($key < count($data)-1){

				$premis[] =  $val;

			}

		}

		$premis = implode("/",$premis);
		$lasmis = $data[count($data)-1];

		$path = $premis."/{,.}".$lasmis;

		foreach(glob($path, GLOB_BRACE) as $key => $val){

			$get_name = explode("/",$val);

			if(
				(trim($get_name[count($get_name)-1]) !== ".") 
					and 
				(trim($get_name[count($get_name)-1]) !== "..")
			){

			$url[] = $val;

			}

		}

		if(!isset($url)){

			$url = null;
			
		}

		return @$url;

	}

}

if(!function_exists("LiteratorScan")){

	/**
	 * Literator SCan
	 *
	 * @param	String
	 * @return	array
	 */

	function LiteratorScan($path){


		$it = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator(
					DirSeparator($path)
					)
				);

			foreach ($it as $file) {

				$url[] = $file;
				
			}

		return $url;

	}

}


if(!function_exists("CalcDirectorySize")){
	
	/**
	 * Calculate the full size of a directory
	 *
	 * @param       string   $DirectoryPath    Directory path
	 */

	function CalcDirectorySize($DirectoryPath) {
	 
	    // I reccomend using a normalize_path function here
	    // to make sure $DirectoryPath contains an ending slash
	 
	    // To display a good looking size you can use a readable_filesize
	    // function.
	 
	    foreach (LiteratorScan($DirectoryPath) as $file) {
						
				$size[] = filesize($file);
		}

		return array_sum($size);
	}

}

if(!function_exists("CountFile")){
	
	/**
	 * Calculate the full size of a directory
	 *
	 * @param       string   $DirectoryPath    Directory path
	 */

	function CountFile($DirectoryPath,$type = null) {
	 
	    // I reccomend using a normalize_path function here
	    // to make sure $DirectoryPath contains an ending slash
	 
	    // To display a good looking size you can use a readable_filesize
	    // function.
	 
	    foreach (LiteratorScan($DirectoryPath) as $file) {
				
				if(is_file($file)) $count['file'][] = 1;

				if(is_dir($file)) $count["dir"][] = 1;
				
		}

		if($type == "file"){
			
			if(isset($count['file']))
			return array_sum($count['file']);
			else return 0;

		}else{

			if(isset($count['dir']))
			return array_sum($count['dir']);
			else return 0;

		}
	}

}


if(!function_exists("CopyDirectory")){

	/**
	 * Copy a file, or recursively copy a folder and its contents
	 * @param       string   $source    Source path
	 * @param       string   $dest      Destination path
	 * @param       int      $permissions New folder creation permissions
	 * @return      bool     Returns true on success, false on failure
	 */

	function CopyDirectory($source, $dest, $permissions = 0755)	{

	    // Check for symlinks
	    if (is_link($source)) {
	        return symlink(readlink($source), $dest);
	    }

	    // Simple copy for a file
	    if (is_file($source)) {
	        return copy($source, $dest);
	    }

	    // Make destination directory
	    if (!is_dir($dest)) {
	        
	        if(mkdir($dest, $permissions) == false){

	        	return false;

	        }
	    }

	    // Loop through the folder
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {
	        // Skip pointers
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        // Deep copy directories
	        CopyDirectory("$source/$entry", "$dest/$entry", $permissions);
	    }

	    // Clean up
	    $dir->close();
	    return true;
	}

}


if(!function_exists("DirSeparator")){

	/**
	 * Dir Separator
	 *
	 * @param	String
	 * @return	string
	 */

	function DirSeparator($url){

		$data = str_replace("\\","/",$url);
		$data = str_replace("http://", "http:>>", $data);
		$data = str_replace("https://", "https:>>", $data);
		$data = str_replace("......../","/",$data);
		$data = str_replace("......./","/",$data);
		$data = str_replace("....../","/",$data);
		$data = str_replace("...../","/",$data);
		$data = str_replace("..../","/",$data);
		$data = str_replace(".../","/",$data);
		$data = str_replace("../","/", $data);
		$data = str_replace("./","/", $data);
		$data = str_replace("/////////", "/", $data);
		$data = str_replace("////////", "/", $data);
		$data = str_replace("///////", "/", $data);
		$data = str_replace("//////", "/", $data);
		$data = str_replace("/////", "/", $data);
		$data = str_replace("////", "/", $data);
		$data = str_replace("///", "/", $data);
		$data = str_replace("//", "/", $data);
		$data = str_replace("/", "/", $data);
		$data = str_replace("https:>>", "https://", $data);
		$data = str_replace("http:>>", "http://", $data);
		return $data;

	}

}