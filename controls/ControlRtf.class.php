<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class ControlRtf extends Control {
	
	protected $text = null;
	
	
	public function __construct(){
			parent::__construct();
			$this->setTpl("ControlRtf.tpl");
	}

	public static  function getDefault(){
		return  new ControlRtf();
	}
	
	public function setValue($value){
			$this->value = $value;
			return $this;
	}


	public function parse(){
		parent::parse();

		if(is_null($this->name)) throw new Exception("No se ha seteado el name");
		
		$this->tpl->setVar("text", $this->value);
		
		if(self::$js){ 
			$this->tpl->setVar("js", $this->tpl->parseBlock("JAVASCRIPT",1));
			$this->tpl->setVar("css", $this->tpl->parseBlock("CSSS",1));
			self::$js = false;
		}
		return $this->tpl->parse();
	}	
}

?>
