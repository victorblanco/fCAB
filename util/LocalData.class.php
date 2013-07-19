<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class LocalData extends Object {
	
	protected static $clase = null;

	public static function getDefault($clase){
		return self::$clase = self::getClass($clase);
	}
	
	public static function getById($id){
	
		if(!isset(self::$clase->data[$id])) return null;
		return self::$clase->data[$id];
	}

	public static function getId($text){
		foreach (self::$clase->data as $id => $value){
			if($value == $text) return $id;
		}
	}

	public static function getKeys($text){
		return array_keys(self::$clase->data);
	}
	
	public static function getValues($text){
		return array_values(self::$clase->data);
	}
	
	public static function getData(){
		return self::$clase->data;
	}

	private static function getClass($clase){
		
		$loc = Locale::getDefault()->getLocale();
		$clase = $clase."_".$loc;
		
		require_once RESOURCES . $clase.".php";
		
		return new $clase();
	}

}
?>
