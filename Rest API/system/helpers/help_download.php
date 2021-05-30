<?php

use application\config\document;

if(!function_exists("force_download")){

	/**
	 * Force Download
	 *
	 * @param	String
	 * @return	String
	 */

	function force_download($path){

		$data = (new document)->content_type();

		$ext = get_extention($path);

		header('Content-Description: File Transfer');

		if(in_array($ext,array_keys($data))){

			foreach($data[$ext] as $key => $val){

				header('Content-Type: '.$val);
					
			}			
		}
		
		header('Content-Disposition: attachment; filename='.basename($path));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($path));
		readfile($path);

	}

}