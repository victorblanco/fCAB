<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Helper {

	public static function getDir($file){
		$partes = explode("/",$file);
		$partes[count($partes) - 1] = "";

		return  implode("/",$partes);

	}

	public static function NormalizeName($name){

		if(is_null($name) || empty($name) ) return null;

		$ret =  explode("_", $name);
		$newName = null;
		foreach ($ret as $name ){
			$newName .= ucfirst($name);
		}

		return $newName;
	}

	public static function normalize($name, $chars = 3, $separate = '/', $returnArray = false){
		
		if(is_null($name) || empty($name) ) return null;
		
		$name = self::getNormalized($name);
		
		$ret =  explode(" ", $name);
		
		$temp = array();
		
		
		if(is_array($ret)){
			foreach($ret as $val){
				if(strlen($val)< $chars) continue;
				$temp[] = $val;
			}
		}
		
		if($returnArray) return $temp;
		
		if(count($temp) > 0)		
			return implode($separate,$temp);
		
		return null;
	}

	public static function createUrl($description,$id,$controller){
		return DefaultLanguage::getLanguage()."/".self::normalize($description)."/".$id."/".$controller;
					
		
	}


	public static function isCallable($controller , $action){
		if(is_file(CONTROLLER.$controller.".php")){
			require_once CONTROLLER.$controller.".php";
	
			$methods = get_class_methods($controller);
			return in_array($action,$methods);
		}
		return false;
	}

	public static function getNormalized($cadena){
		
		
		$cadena  = str_replace('&#34;','',$cadena);
		$cadena = strtr($cadena,"*\"'^¨&·/","        ");
		$cadena = strtr($cadena,"áàäÁÀÄÃÅÂãâå","aaaAAAAAAaaa");
		$cadena = strtr($cadena,"éèëÉÈËÊê","eeeEEEEe");
		$cadena = strtr($cadena,"íìïÍÌÏ","iiiIII");
		$cadena = strtr($cadena,"óòöÓÒÖÕÔôõ","oooOOOOOoo");
		$cadena = strtr($cadena,"úùüÚÙÜÛû","uuuUUUUu");
		$cadena = strtr($cadena,"ñÑçÇ","nNcC");
		$cadena = strtr($cadena, "=><;+(),.:%ªº¡!?¿/\n\r\t»«µ±®©§²³¤$@", "                                  ");
		$cadena = preg_replace("/\s+/"," ",$cadena);
		$cadena = preg_replace("/-+/","-",$cadena);

		return $cadena;
	}
	private static function _normalize($text){
		$a = "&aacute; &agrave; &auml; &Aacute; &Agrave; &Auml; &Atilde; &Aring; &Acirc; &atilde; &acirc; &aring; &eacute; &egrave; &euml; &Eacute; &Egrave; &Euml; &Ecirc; &ecirc; &iacute; &igrave; &iuml; &Iacute; &Igrave; &Iuml; &oacute; &ograve; &ouml; &Oacute; &Ograve; &Ouml; &Otilde; &Ocirc; &ocirc; &otilde; &uacute; &ugrave; &uuml; &Uacute; &Ugrave; &Uuml; &Ucirc; &ucirc; &ntilde; &Ntilde; &ccedil; &Ccedil; &quot;";
		
		$b= array("a","a","a","A","A","A","A","A","A","a","a","a","e","e","e","E","E","E","E","e","i","i","i","I","I","I","o","o","o","O","O","O","O","O","o","o","u","u","u","U","U","U","U","u","n","N","c","C"," ");
		
		$a = explode(" ",$a);
		
		foreach($a as $k => $v1){
			$text = ereg_replace($v1  , $b[$k] , $text);
		}
		
		return $text;
	}
	
	public static function getPalabras($text, $palabras){
		$temp = explode(" ",strip_tags($text));
		$acum = null;
		if (is_array($temp)){
			foreach($temp as $num => $txt){
				if($num == $palabras) break;
				$acum .= $txt . " ";
			}
			return $acum;
		}
		return $text;
	}
	
	public static function getId(){
		$temp = explode("/",URL::getActualUrl());
		if(is_array($temp))
		return $temp[count($temp)-2];
	}
	
	
	/**
	*	@Description: Convierte codigo html en su correspondiente
	*				para poder ser mostrado por pantalla
	*
	*/
	public static function html($value){
		return htmlspecialchars($value, ENT_QUOTES);
	}
	
	public static  function makeDataPage($text){
		$data = array("title" =>'', "keywords" => '', "description" => '');
		
		$temp = self::sortRelevanceWords($text);
		$tempArray = array();
		if(is_array($temp)){
			$cont = 0;
			foreach($temp  as $txt => $nada){
				if(Conf::get()->keywords == $cont) break;
					$tempArray[] = $txt;
				$cont++;
			}
			$data["keywords"] = implode(",",$tempArray);
		}
		
		$data["title"] = self::getPalabras($text, Conf::get()->title);
		$data["description"] = self::getPalabras($text, Conf::get()->description);
		return $data;
	}
	
	public static function sortRelevanceWords($text){
		$data = array();
		$temp = self::normalize($text, 4,' ', true);
		if(is_array($temp)){
			foreach($temp  as $k => $txt){
				@$data[strtolower($txt)] += 1;
			}
			arsort($data);
		}
		return $data;
	}
}
/*

class Appication {


	public static function run(){
		
		$controller = Url::getController();
		$action = Url::getAction();
		
		$controller = Helper::NormalizeName($controller);
		$action = Helper::NormalizeName($action);
	}
}
*/
?>
