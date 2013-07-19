<?php 

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class Conf {

	private static $data = null;

	function __construct() {
		Debug::add("LLamada deprectated!!!");
		self::$data = new HashTable();
	
		try {
		
			$xml = new Xml(DATA."conf.xml");
			$i = $xml->getIterator();
			foreach($i->item as $item) { 
				self::$data->$item["name"] = $item["value"];
			}
			
		}catch(Exception $e){
			Debug::add($e);
		}
	}

	
	public static function get(){
		return self::$data;
	}
	
	
	
}

