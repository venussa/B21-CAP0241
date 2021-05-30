<?php

if(!function_exists("provinsi")){

	/**
	 * get province data
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function provinsi(){

		$path = SERVER."/application/plugin/IndonesianTerritory/provinsi.json";

		$get_data = implode(null,file($path));

		return json_decode($get_data);

	}

}


if(!function_exists("kabupaten")){

	/**
	 * get kabupaten data
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function kabupaten($id = "p1"){

		$id = (empty($id)) ? "p1" : $id;

		$path = SERVER."/application/plugin/IndonesianTerritory/kabupaten/".$id.".json";

		$get_data = implode(null,file($path));

		return json_decode($get_data);

	}

}

	
if(!function_exists("kecamatan")){

	/**
	 * get kecamatan data
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function kecamatan($id = "k1"){

		$id = (empty($id)) ? "k1" : $id;

		$path = SERVER."/application/plugin/IndonesianTerritory/kecamatan/".$id.".json";

		$get_data = implode(null,file($path));

		$data = json_decode($get_data);

		foreach($data as $key => $val){

			$kecamatan[$val->kodepos] = $val->kecamatan;

		}

		$kecamatan = array_unique($kecamatan);

		return $kecamatan;

	}

}


if(!function_exists("kodepos")){

	/**
	 * get kodepos data
	 *
	 * @param	string
	 * @param	mixed
	 * @return	mixed
	 */

	function kodepos($id = "k1", $kecamatan = null){

		$id = (empty($id)) ? "k1" : $id;

		$path = SERVER."/application/plugin/IndonesianTerritory/kecamatan/".$id.".json";

		$get_data = implode(null,file($path));

		$data = json_decode($get_data);

		foreach($data as $key => $val){

			if($kecamatan == $val->kecamatan) $kp[] = $val->kodepos;

		}

		return (isset($kp)) ? array_unique($kp) : [];

	}

}

