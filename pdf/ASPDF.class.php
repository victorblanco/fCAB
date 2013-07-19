<?php
require_once("core/pdf/HTML2FPDF.class.php");
 class ASPDF extends  HTML2FPDF  {
	public $langues = "es";
	function __construc(){
	
	
	}
	
	static function isPDF(){
		return View::isPDF();
	}
	static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ASPDF();
	
		return $i;	
	}

}
