<?php

/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: Víctor Blanco
 *	Date: 10/02/2008
 *	Company:
 */

class Object {

	static $backtrace;

	static $sw = true;

	function __construct(){

	}

	public function __destruct(){
		unset($this);
	}

	public function __toString(){
		$temp = "METHODS: ";
		$d = get_class_methods($this);
		if (is_array($d)){
			foreach($d as $k => $v){
				$temp .= " $v(), ";
			}
		}
		return $temp;
	}

	/**
	 * Returns the unique internal hash for this Object.
	 *
	 * @return string
	 */
	public function id() {
		return spl_object_hash( $this );
	}


	public static function backtrace(){
		self::$backtrace = true;
	}


	public function __call( $metodo, $arg ){
		$r = new ReflectionObject($this);
		if( strpos($metodo, "get") === 0 ){
			$attr 	 = preg_replace ("/^get/", "", $metodo);
			$attr{0} = strtolower($attr{0});
			if($r->hasProperty($attr)){
				return $this->$attr;
			}else{
				throw new GenException("Propiedad $attr no encontrada.");
			}
		}elseif( strpos($metodo, "set") === 0 ){
			$attr 	 = preg_replace ("/^set/", "", $metodo);
			$attr{0} = strtolower($attr{0});
				
			if($r->hasProperty( $attr)){
				$this->$attr = $arg[0];
			}else{
				throw new GenException("Propiedad $attr no encontrada.");
			}
			return $this;
		}else{
			throw new GenException("Method: $metodo no encontrado.");
		}

		return false;
	}
}

