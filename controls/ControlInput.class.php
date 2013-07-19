<?php

class ControlInput extends Control implements IFactory{
	protected $type_ ="text";
	protected $id;
	protected $onChange;
	protected $onClick;
	protected $onBlur;
	protected $value;
	protected $disabled;
	protected $class;
	protected $multiple;

	public function __construct() {
		parent::__construct();
		$this->setTpl("ControlInput.tpl");
		$this->clearObject();
	}
	public static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ControlInput();
	
		return $i;
	}

	public function setOnChange($w) {
		$this->onChange = $w;
		return $this;
	}
	
	public function setValue($v) {
		$this->value = $v;
		return $this;
	}
	
	public function setId($i){
		$this->id= $i;
		return $this;
	}
	
	public function setClass($c){
		$this->class= $c;
		return $this;
	}
	public function setDisabled($c){
		$this->disabled="$c";
		return $this;	
	}
	
	public function setType($t){
		$this->type_= $t;
		return $this;
	}
	public function setOnClick($c){
		$this->onClick= $c;
		return $this;
	}
	public function setOnBlur($h){
		$this->onBlur= $h;
		return $this;
	}
	public function clearObject(){
		$this->disabled = false;
		$this->type_ = "text";
		$this->onClick="";
		$this->class="";
		$this->onChange="";
		
	}
	private function isHidden($type){
		if ($type == "hidden"){
			return true;
		}else{
			return false;		
		}
	}
	
	public function parse(){
		parent::parse();
		if ($this->disabled){
			$this->tpl->setVar("disabled","readonly='readonly'");
		}
		$this->tpl->setVar("type",$this->type_);
		$this->tpl->setVar("onChange",$this->onChange);
		$this->tpl->setVar("onClick",$this->onChange);
		$this->tpl->setVar("value",$this->value);
		$this->tpl->setVar("onBlur",$this->onBlur);
		$this->tpl->setVar("class",$this->class);
		$this->tpl->setVar("id",$this->id);
		$type = $this->type_;
		$this->clearObject();
		if (View::isPDF() || View::isXLS()){
			if ($this->isHidden($type))
				return "";
			else
				return $this->value;
		}else{
			return $this->tpl->parse();
		}
	}


}



