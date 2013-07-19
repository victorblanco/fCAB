<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class ControlToolTip extends Control {
	
	protected $text = null;
	
	protected $link  = null;
	
	public function __construct(){
			parent::__construct();
			$this->setTpl("ControlToolTip.tpl");
	}

	public static  function getDefault(){
		return  new ControlToolTip();
	}
	
	public function setText($value){
			$this->text = $value;
			return $this;
	}

	public function setLink($value){
			$this->link = $value;
			return $this;
	}
	

	public function parse(){
		parent::parse();
		
		$this->tpl->setVar("text", $this->text);
		$this->tpl->setVar("link", $this->link);

		return $this->tpl->parse();
	}	
}

?>
