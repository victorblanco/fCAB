<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class DefaultLanguage {



	/**
	* @Description:  Setea en session el idioma
	*				
	* @Access: Public
	* @Params: $lang String
	* @Return: String
	*/
	public static function setLanguage($lang){
		
		if (!Session::isRegister("language"))
			Session::register("language");
			
		Session::set("language", $lang);
		
		Locale::setDefault(self::getLocale($lang));
		return Session::get("language");
	}

	/**
	* @Description: Obtiene el idioma en session , si no existe trae 
	*				el default del cliente
	*				
	* @Access: Public
	* @Return: String
	*/	
	public static function getLanguage(){
		
		if (!Session::isRegister("language"))
			self::setLanguage(self::getDefaultLanguage());

		return Session::get("language");
	}

	/**
	* @Description: Retorna el hash de idiomas permitidos
	*				
	* @Access: Public
	* @Return: String
	*/	
	public static function getAcceptLanguage(){
		static $data = null;

		if(is_null($data)){
			$xml = new Xml(DATA."languages.xml");
			$i = $xml->getIterator();
			$data = array();
			foreach($i->item as $item) { 
				$data[] = (string)$item['lang'];
			}
		}
		return $data;
	}
	
	public static function getLocale($lang){
		static $data = array();
		if(is_null(@$data[$lang])){
			$xml = new Xml(DATA."languages.xml");
			$i = $xml->getIterator();
			foreach($i->item as $item) { 
				if((string)$item['lang'] == (string)$lang){
					$data[(string)$item['lang']]  = (string)$item["locale"];
				}
			}
		}
		return $data[$lang];
	}


	/**
	* @Description: Obtiene el idioma del navegador del cliente
	*				
	* @Access: Public
	* @Return: String
	*/	
	public static function getDefaultLanguage(){
		
		$default = "es";
		
		$ln = strtolower(Http::$server->HTTP_ACCEPT_LANGUAGE);
		$ua = strtolower(Http::$server->HTTP_USER_AGENT);
		
		$data = self::getAcceptLanguage();
		
		foreach($data as $k){
			if(strpos($ln, $k)===0){
				return $k;
			}
		}
		
		foreach($data as $k){
			if(strpos($ln, $k)!==false){
				return $k;
			}
		}
		
		foreach($data as $k){
			if(preg_match("/[\[\( ]{$k}[;,_\-\)]/",$ua)){
				return $k;
			}
		}
		
		return $default;
	}

	

}


?>