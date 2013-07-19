<?php

class ControlForm extends Control implements IFactory{
	protected $id;
	protected $onSubmit;
	protected $action;
	protected $CONTENT;
	protected $method;
	public function __construct() {
		parent::__construct();
		$this->setTpl("ControlForm.tpl");

	}

	public static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ControlForm();
			return $i;
	}

	public function setOnSubmit($s) {
		$this->onSubmit = $s;
		return $this;
	}
	public function setMethod($m) {
		$this->method = $m;
		return $this;
	}
	public function setAction($a) {
		$this->action = $a;
		return $this;
	}
	
	public function setId($i){
		$this->id= $i;
		return $this;
	}
	
	public function setCONTENT($c){
		$this->CONTENT= $c;
		return $this;
	}

	public function parse(){
		parent::parse();
		$this->tpl->setVar("submit",$this->onSubmit);
		$this->tpl->setVar("CONTENT",$this->CONTENT);
		$this->tpl->setVar("action",$this->action);
		$this->tpl->setVar("method",$this->method);
		$this->tpl->setVar("id",$this->id);
		return $this->tpl->parse();
	}


}


?>
