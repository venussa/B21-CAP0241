<?php

function token()
{
	foreach (getallheaders() as $name => $value) {
    	$header[$name] = $value;
	}

	if (!isset($header["token"])) return false;
	return $header["token"];

}

function process_token()
{
	foreach (getallheaders() as $name => $value) {
    	$header[$name] = $value;
	}

	if (!isset($header["process_token"])) return false;
	return $header["process_token"];

}