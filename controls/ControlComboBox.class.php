<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class ControlComboBox extends ControlInput {

	protected $default;
	
	public function __construct(){
		parent::__construct();
		$this->setTpl("ControlComboBox.tpl");
	}
	
	public function setDefault($value){
			$this->default = $value;
			return $this;
	}
	
	public static function getDefault(){
		return new ControlComboBox();
	}

	public function setMultiple($m){
		$this->multiple= $m;
		return $this;
	}
	
	public function parse(){
		parent::parse();
		if ($this->disabled){
			$this->tpl->setVar("disabled","disabled='disabled'");
		}
		if(is_null($this->name)) throw new Exception("No se ha seteado el name");
		$this->tpl->setVar("multiple", $this->multiple);
		$temp = null;

		switch(gettype($this->source)){
			
			case "array":
				if(is_array($this->default)){
					foreach($this->default as $k => $v){
						$this->tpl->setVarBlock("ROW","id",$k);
						$this->tpl->setVarBlock("ROW","value",$v);
						$temp .= $this->tpl->parseBlock("ROW",1);
					}
				}
				
				foreach($this->source as $key => $value){
					$this->tpl->setVarBlock("ROW","id",$key);
					$this->tpl->setVarBlock("ROW","value",$value);
					if ((string)$this->selected == (string)$key) 
						$this->tpl->setVarBlock("ROW","selected","selected='selected'");
					$temp .= $this->tpl->parseBlock("ROW",1);
				}
			break;
			
			case "object":
				if(is_array($this->default)){
					foreach($this->default as $k => $v){
						$this->tpl->setVarBlock("ROW","id",$k);
						$this->tpl->setVarBlock("ROW","value",$v);
						$temp .= $this->tpl->parseBlock("ROW",1);
					}
				}
				
				while($rs = $this->source->next($this->rs)){
					$row = $rs->get();
					$this->tpl->setVarBlock("ROW","id",$row[0]);
					$this->tpl->setVarBlock("ROW","value",$row[1]);
					if ((string)$this->selected == (string)$row[0]) 
						$this->tpl->setVarBlock("ROW","selected","selected='selected'");
					$temp .= $this->tpl->parseBlock("ROW",1);
				}
			break;
			
		}
		
		$this->tpl->setVar("rows",$temp);
		if (View::isPDF() || View::isXLS()){
			return $this->selected;	
		}else{
			return $this->tpl->parse();
		}
		
	}

}
