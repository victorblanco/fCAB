<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class Cookie extends Object implements IFactory{

	protected $days =  null;
	
	

	public function __construct($days = 90){
		parent::__construct();
		$this->days = $days;
	}

	public static function getDefault(){
		static $i = null;
		
		if(is_null($i)) $i = new Cookie();
		return $i;
	}

	public function setDays($value){
		$this->days = $value;
	}

	public function __get($name){
		return @$_COOKIE[$name];
	}
	
	public function __set($name, $value){
		if(is_null($value)){
			setcookie($name, $value , time() - ((time()+3600) * $this->days*24), "/", ""); 
			return $this;
		}

		setcookie($name, $value , (time()+3600) * ($this->days*24), "/", ""); 
		return $this;
	}
	
	public function set($name,$value){
		return $this->__set($name, $value);
	}
	
	public function get($name){
		return @$_COOKIE["$name"];
	}
	
	
	
	public function getData(){
		return $_COOKIE;
	}
	
	public function delete($name){
		$this->__set($name,null);
		return $this;
	}
	
	
	public function __toString(){
		$temp = null;
		
		foreach($_COOKIE as $name => $value){
			if(is_array($value)){
				$temp .= "$name (Array)\n\n";
				foreach($value as $k => $v){
					$temp .= " \t$k => $v\n";	
				}
			}else{
				$temp .= "$name => $value\n";
			}
		}
		return $temp;
	}


}

?>
