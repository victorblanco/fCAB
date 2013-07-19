<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/


abstract class Control extends Object {

	protected  $tpl;
	
	protected  $source;
	protected $rs;
	
	protected  $class;
	
	protected $event;
	
	protected $name;
	
	protected $selected;
	
	protected static $js = true;


	public function setName($value){
			$this->name = $value;
			return $this;
	}
	
	public function setEvent($value){
			$this->event = $value;
			return $this;
	}
	
	public function setClass($value){
			$this->class = $value;
			return $this;
	}

	public function setTpl($value){
			$this->tpl = new Template($value, controls_tpl_dir, tpl_pre); 
			return $this;
	}
	/**
	 * En el ComboBox el $value puede ser un array o un datasource
	 * Si es un datasource hay que pasar el siguiente parametro q es el resulset.
	 * 
	 * @param Array - Datasource $value
	 * @param unknown_type $rs
	 */
	public function setSource($value, $rs =null){
			$this->source  	= $value; 
			$this->rs		= $rs;	
			return $this;
	}
	
	public function setSelected($value = null){
			$this->selected = $value;
			return $this;
	}
	
	protected function parse(){
		try{
		$this->tpl->setVar("name", $this->name);
		$this->tpl->setVar("event", $this->event);
		$this->tpl->setVar("class", $this->class);
		}catch( Exception $eeee){
			Debug::add($eeee);
		}
	}

}
?>
