<?php

namespace system\library;

 /**
 * pushstateurl Class
 *
 * this class will colaboration with javascript
 * pjaxstandalone.js to hide page load and incrase page speed load
 * without using cache
 *
 * @package     system
 * @subpackage  library
 * @category    data transmision
 */

class pushstateurl{

	/**
    * Web Container
    *
    * @var string
    */
	public $container;

	/**
    * Web Content
    *
    * @var string
    */
	public $content;

    /**
    * Content class
    *
    * @var string
    */
    public $class;

    /**
    * Content action
    *
    * @var string
    */
    public $action = array(

        "before"    => null,
        "success"   => null,
        "error"     => null,

    );

	// --------------------------------------------------------------------

    /**
     * Load Pjax stand alone javascript file
     *
     * @return  string
     * @return  bool
     */
	public function pjax_load(){

		return "<script src='".homeUrl()."/application/plugin/PjaxStandAlone/pjax-standalone.min.js'></script>\n<script src='".homeUrl()."/application/plugin/PjaxStandAlone/jquery.pjax.js'></script>";


	}

	// --------------------------------------------------------------------

    /**
     * RLoad Ajax Configuration
     *
     * @return  array
     */
	public function pjax_write(){

		require_once(SERVER."/application/plugin/PjaxStandAlone/pjax.php");
		
		return pjax($this->class,$this->container,$this->content,$this->action);

	}

	// --------------------------------------------------------------------

    /**
     * Running pjax
     *
     * @return  string
     * @return void
     * @return mixed
     */

    public function pjax_start(){

    	$data = array(

    		$this->pjax_load(),
    		$this->pjax_write(),

    	);

    	return implode(null,$data);
    }
}