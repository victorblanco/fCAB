<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class Car extends Object {

	protected $name = null;

	protected $data = array();


	public function __construct($name = "carro"){
		parent::__construct();
		$this->name = $name;
		$this->data = array();
		Session::register($name);
	}


	public static function getDefault($name = "carro"){
		return new Car($name);
	}
	
	
	public function add($id = null, $objeto = null){
		
		$this->data = $this->get();
		
		if(!is_null($id))	$this->data[$id] = $objeto;
		else $this->data[] = $objeto;
		
		Session::set($this->name, serialize($this->data));
		
		return $this;
	}	
	
	
	public function get(){
		$t = unserialize(Session::get($this->name));
		if($t)$this->data = $t;
		
		return $this->data;
	}
	
	
	public function delete($id = null){
		$this->data = $this->get();
		if(is_null($id))  $this->data = array();
		
		$cont = 0;
		foreach($this->data as $index => $object){
			if($index == $id) break;
			$cont ++;
		}
		
		array_splice($this->data, $cont,1);
		
		Session::set($this->name, serialize($this->data));
		
		return $this;
	}	



}


?>
