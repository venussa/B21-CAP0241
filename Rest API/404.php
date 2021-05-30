<?php 

/*
|--------------------------------------------------------------------------
| Selection Device category and platform for display 404 page
|--------------------------------------------------------------------------
|
| if the response is true, system will load 4040.php from mobile page
| will work if us sing accelerate mobile page mode
| and will show response heade 404 Not found
|
*/

 // heade response
header("HTTP/1.0 404 Not Found"); 

// show 404 page for mobile device
if(is_mobile() == true){

	// detecting is 404 mobile file available
	if(is_file(SERVER."/application/views/mobile/404.php")){

		require_once(SERVER."/application/views/mobile/404.php");

		exit;

	// detecting is 404 non mobile file available
	}elseif(is_file(SERVER."/application/views/404.php")){

		require_once(SERVER."/application/views/404.php");

		exit;

	}

// show 404 page for non mobile device
}else{

	// detecting is 404 non mobile file available
	if(is_file(SERVER."/application/views/desktop/404.php")){

		require_once(SERVER."/application/views/desktop/404.php");

		exit;
		
	// detecting is 404 non mobile file available
	}elseif(is_file(SERVER."/application/views/404.php")){

		require_once(SERVER."/application/views/404.php");

		exit;

	}

}

/*
 *---------------------------------------------------------------
 * DEFAULT 404 PAGE
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current page if you not set any 404 page in other file
 */

?>
<!DOCTYPE html>
<html>
<head>
	<title>404 Not Found</title>

	<style>
		*{
			font-family: "consolas";
			text-align: center;
		}
	</style>
</head>
<body>
<h1>404 Not Found</h1>
</body>
</html>