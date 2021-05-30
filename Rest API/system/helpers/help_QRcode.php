<?php

if(!function_exists("createQR")){

	/**
	 * QRcode generator
	 *
	 * @param	text
	 * @return	mixed
	 */

	function createQR($text = null,$width = 50, $height = 50,$filename = "QRcode",$save_path = null,$quality_score = 100){

		require_once(SERVER."/application/plugin/phpqrcode/phpqrcode.php");

		if($save_path == null){

			$save_path = SERVER."/application/cache/qrcode/";
		}

		if(file_exists($save_path) == false){

			mkdir($save_path);

		}

		

		$tempdir = $save_path;
		$isi_teks = $text;
		$namafile = $filename.".png";
		$quality = 'H';
		$ukuran = $quality_score;
		$padding = 0;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);

			return json_decode(json_encode(array(

						"url" => homeUrl()."/application/cache/qrcode/".$filename.".png",
						"image" => "<img src='".homeUrl()."/application/cache/qrcode/".$filename.".png' width='".$width."' height='".$height."'>",
					)
				)
			);

		

	}

}
