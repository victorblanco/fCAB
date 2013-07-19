<?php

class Printer extends Object{
	protected $printer;

	function __construct(){

	}

	public static function getDefault(){
		static $i =null;
		if (is_null($i)){
			$i = new Printer();
		}
		return $i;
	}

	public function setImpresora($printer){
		$this->printer = $printer;
		return $this;
	}

	public function printFile($file){
		return System::getDefault()->execute($this->getComando().$file)->getTxtRespuesta();
	}

	protected function getComando(){
		if ($this->printer)
			return "lpr -H ".$this->printer;
		else
			return "lpr ";
	}



}
