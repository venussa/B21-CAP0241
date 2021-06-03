<?php

function token($token = null)
{
	foreach (getallheaders() as $name => $value) {
    	$header[$name] = $value;
	}

	if (!empty($token)) return $token;
	else if (!isset($header["token"])) return false;
	return $header["token"];

}

function process_token($process_token = null)
{
	foreach (getallheaders() as $name => $value) {
    	$header[$name] = $value;
	}

	if (!empty($process_token)) return $process_token;
	else if (!isset($header["process_token"])) return false;
	return $header["process_token"];

}