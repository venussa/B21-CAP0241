<?php

namespace system\library;

 /**
 * upload Class
 *
 * doing upload action with some 
 * allowed content and spesification
 *
 * @package		system
 * @subpackage	library
 * @category	caracter set
 */

class upload {

	/**
	 * new name after upload
	 *
	 * @var string
	 */

	public $newname;

	/**
	 * path upload of file
	 *
	 * @var string
	 */

	public $destination;

	/**
	 * disallow uplload extention list of file
	 *
	 * @var string
	 */

	public $allow_extention = [];

	/**
	 * max file upload size
	 *
	 * @var string
	 */

	public $max_file_size = 100;

	/**
	 * Attribute name for $_FILES method
	 *
	 * @var string
	 */

	public $attribute_name = "file";

	// --------------------------------------------------------------------

	/**
	 * Register of attribute name
	 *
	 * @return	array
	 */

		private function scan_method(){

			if(isset($_FILES[$this->attribute_name]))

			return $_FILES[$this->attribute_name];

		}

	// --------------------------------------------------------------------

	/**
	 * Scanning bout filename who have illegal extention or scanning if didn't change name
	 *
	 * @return	string
	 */

		private function filter_name(){

			if(count($this->allow_extention) > 0){

			if(!empty($this->newname)){

					if(!in_array(get_extention($this->newname),$this->allow_extention)){

						return false;

					}else{

						return $this->newname;

					}

				}else{

					return $this->scan_method()['name'];

				}

			}else{

				if(!empty($this->newname)){

					return $this->newname;

				}else{

					return $this->scan_method()['name'];

				}

			}
		}

	// --------------------------------------------------------------------

	/**
	 * Detect the size of the file that is allowed to be uploaded
	 *
	 * @return	bool
	 */

		private function filter_max_size(){

			$size = ($this->scan_method()['size'] / 1000000);

			if($size > $this->max_file_size){

				return false;

			}else{

				return true;

			}

		}

	/**
	 * Upload Action
	 *
	 * @return	bool
	 */

		public function start_upload(){

			if($this->filter_name() !== false){

				if($this->filter_max_size() == true){

					if(move_uploaded_file(
						$this->scan_method()['tmp_name'], 
						DirSeparator($this->destination."/".$this->filter_name())
					) ){

						return true;

					}else return false;

				}else return false;

			}else return false;

		}
}