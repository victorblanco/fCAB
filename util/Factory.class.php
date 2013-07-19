<?php 
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Factory extends Object {

	public $path = null;
	
	protected $instance = array();
	
	public function __construct($path){
		Debug::add("ERROR: Llamada deprecate");
		$this->path = $path;
	}

	public function __get( $class ) {
		Debug::add("ERROR: Llamada deprecate, en la factorización de la  clase: $class.");
		if (is_null( @$this->instance[$class] ) ){
			try{
				$this->instance[$class] = new $class();
			}catch(Exception $e){
				throw new Exception("No se encuentra la clase: $class");
			}
		}
		
		return $this->instance[$class];
	}
}


