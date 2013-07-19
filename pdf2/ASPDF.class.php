<?php
require_once("core/pdf/html2pdf.class.php");
 class ASPDF extends  HTML2PDF {
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
