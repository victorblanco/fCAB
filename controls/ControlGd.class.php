<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class ControlGd extends Control {

	protected $isOk = false;
	
	
	public function __construct(){
		parent::__construct();
		$this->setTpl("ControlGd.tpl");
	}


	private  function calculate(){
		return rand(1111,9999);
	}

	public  function isOk(){
		
		if(is_null($this->name)) throw new Exception("No se ha seteado el name");
		
		
		
		if(!Session::isRegister($this->name))	Session::register($this->name);
		
		if (Session::get($this->name) == $this->selected){
			$this->isOk = true;
		}
		
		return $this->isOk;
	}


	public static  function getDefault(){
		return new ControlGd();
	}

	public function parse(){
		$this->selected = $this->calculate();
		Session::set($this->name, $this->selected);
		parent::parse();
		
		$this->tpl->setVar("selected",$this->name);
		
		return $this->tpl->parse();
	}	
}

