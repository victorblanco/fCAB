<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class Model extends SimpleXMLElement {
	
	public static $view;
	
	public static function getDefault($view = null){
	
/*		$m =  new  Model('<model/>');
		
		$data = $m->addChild("data");
		
		foreach(Http::get() as $name => $value)
			$data["$name"] = $value;
		
		foreach(Http::post() as $name => $value)
			@$data["$name"] = $value;

			
		$data["controller"] = URL::getController();
		$data["action"] = URL::getAction();
*/
			
		return new  Model('<model/>');	
	}
	
	
	public function encode($text){
		return utf8_encode($text);
	}
	
	public function decode($text){
		return utf8_decode($text);
	}
	
	public function xml(){
 		return $this->asXML();
	}

	public function addRecorSet(DB $ds, $name = "rows", $encode = false){
	
		$name = $this->addChild($name);
		while ($row = $ds->next()){
		
			$item = $name->addChild("item");
			foreach ($row->get() as $index => $campo){
				if(!is_numeric($index)){
					if($encode)
						$item["$index"] = $this->encode($row->$index);
					else
						$item["$index"] = $row->$index;
				}
			}
		}
		return $this;
	}
	
	
	public function addHashTable(HashTable $h , $name = "hashtable", $encode = false){
	
		$name = $this->addChild($name);
		foreach($h as $campo => $value){
			$item = $name->addChild("item");
			if($encode)
				$item["$campo"] = $this->encode($value);
			else
				$item["$campo"] = $value;
		}
		return $this;
	}
	
	public function addArray(array $datos, $name = "array", $encode = false){
		
		$name = $this->addChild($name);
		if (count($datos) > 0){
			foreach ($datos as $key => $value){
				if (is_numeric($key)) throw new Exception("Solamente se permiten arrays asociativos");
				
				$item = $name->addChild("item");
				if($encode)
					$item["$key"] = $this->encode($value);
				else
					$item["$key"] = $value;
			}
		}
		return $this;
	}
	
	
	



}

?>
