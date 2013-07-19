<?php


class UnitTest extends Object{
	
	
	
	public function init( $test = "default" ){
		$xml = $this->getXmlFile($test);
				
		
	}	
	
	protected function processXml( $xml ){
		foreach ($xml->tests->test as $test){
			$this->execTest($test);
		}
	}
	
	protected function execTest( $test ){
		$controller = $test["controller"] . "Controller";
		$action		= $test["action"] ?  $test["action"] : "DefaultAction";
		
	}
	
	protected function getXmlFile($test){
		return simplexml_load_file($this->getFileName($test));
	}
	
	protected function getFileName( $test ){
		$file	= TEST.$filename.".xml";
		if(file_exists(TEST.$filename.".xml")){
			return $file;
		}else{
			throw new GenException(" Test $test no encontrado.");
		}
	}
	
}