<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class ControlCalendar extends Control {
	
	public function __construct(){
		parent::__construct();
		$this->setTpl("ControlCalendar.tpl");
	}
	
	public static function getDefault(){
		return new ControlCalendar();
	}
	
	public function parse(){
		parent::parse();
		$this->tpl->setVar("selected",$this->selected);
		if (View::isPDF() || View::isXLS()){
			return	$this->selected;
		}else{
			return $this->tpl->parse();
		}
	}


}

?>
