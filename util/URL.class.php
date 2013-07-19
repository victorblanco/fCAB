<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/
class URL {

	private static $urlWithoutLanguage 	= null;
	
	private static $urlWithLanguage 	= null;
	
	private static $languageInUrl 		= null;
	
	private static $languageByUrl 		= null;
	
	
	
	
	
	/**
	* @Description: Redirecciona al navegador a su idioma
	*				
	* @Access: Public
	* @Return: Void
	*/
	
	public static function redirectLanguage($ln = null){
		if(is_null($ln)){
		//	header ("Location: /".Conf::get()->proyect."/".DefaultLanguage::getLanguage()."/");
		}else{
		//	header ("Location: /".Conf::get()->proyect."/".$ln."/");
		}
	}
	
	/**
	* @Description: Asegura que disponemos de una barra 
	*				al final de la url
	* @Access: Public
	* @Return: Void
	*/
	public static function makeSlash(){
		$url = Http::$server->PATH_INFO;
		
		# aseguramos que la url termina con una barra
		$temp = explode("/",$url);
		if ( strlen($temp[count($temp)-1]) == "2"  && substr($url,strlen($url)-1,1) != "/" ){
		//	header ("Location: $url"."/");
		}
	}
	
	/**
	* @Description: Retorna la url actual
	*
	* @Access: Public
	* @Return: String
	*/
	public static function getActualUrl(){
		return self::getActualUrlClear();
	}
	
	public static function getUrlWhidOutController(){
	
	}
	
	public function replaceLanguage($urLang, $ln){
		return str_replace("/$urLang/","/$ln/",self::getFullUrl());
	}
	
	public static function getUrlWhidOutAction(){
		$c = self::getController();		
		$a = self::getAction();		
		
		if($c == "DefaultController" && $a == "defaultAction"){
			return self::getActualUrl();
		}
		$temp =  explode("Controller", $c);
		$c = $temp[0];
		
		
		$ret = self::getActualUrl();
		$ret = explode("/",$ret);
		
		$url = array();
		foreach($ret as $k => $val){
			if($k == count($ret)-1) break;
			$url[] = $val;
		}
		return implode("/",$url)."/". $c;
		
	}

	private static function getActualUrlClear(){
		$t = explode("/",Http::$server->PATH_INFO);
		$url = array();
		if(is_array($t)){
			foreach($t as $v){
				if($v == 'index.php') continue;
				$url[] = $v;
			}
		}
		return implode("/",$url);

	}
	
	
	
	/**
	* @Description: Retorna la url con el idioma en ella
	*
	* @Access: Public
	* @Return: String
	*/
	public static function getUrlWithoutLanguage(){
		
		if (is_null(self::$urlWithoutLanguage)){

			$urlData = explode("/",self::getActualUrl());
			$lns = DefaultLanguage::getAcceptLanguage();
		
			$url = null;
		
			foreach($lns as $i => $ln){
				if(in_array($ln,$urlData)){
					foreach ($urlData as $j => $part){
						if($part == 'index.php') continue;
						if( $part != $ln && !empty($part)){
							$url .= $part."/";		
						}
					}

					self::$urlWithoutLanguage = $url;	
					return self::$urlWithoutLanguage;		
				}
			}
			self::$urlWithoutLanguage = self::getActualUrl();
		}
		return self::$urlWithoutLanguage;
	}
	
	/**
	* @Description: Retorna la url sin el idioma en ella
	*
	* @Access: Public
	* @Return: String or false
	*/
	public static function  getUrlWithLanguage(){
		if(self::hasLanguageInUrl()){
			self::$urlWithLanguage = self::getActualUrl();
		}else{
			 self::$urlWithLanguage = self::getActualUrl();
		}
		return self::$urlWithLanguage;
	}
	
	/**
	* @Description: Comprueba si la url contiene el idioma
	*
	* @Access: Public
	* @Return: Bolean
	*/	
	public static function  hasLanguageInUrl(){
	
		if(is_null(self::$languageInUrl)){
			$lns = DefaultLanguage::getAcceptLanguage();
			$urlData = explode("/",self::getActualUrl());
			
			foreach($lns as $i => $ln){
				if(in_array($ln,$urlData)){
					self::$languageInUrl = true;
					return self::$languageInUrl;
				}
			}
			self::$languageInUrl = false;
		}
		
		return self::$languageInUrl;
	}
	
	/**
	* @Description: Comprueba si la url contiene el idioma
	*
	* @Access: Public
	* @Return: Bolean
	*/	
	public static function  hasThisLanguageInUrl($ln){
	
		$urlData = explode("/",self::getActualUrl());
		
		return in_array($ln,$urlData);
	}
	
	
	/**
	* @Description: Obtiene el idioma de la url
	*
	* @Access: Public
	* @Return: String or null
	*/	
	public static function  getLanguageByUrl(){
	
		if (is_null(self::$languageByUrl)){
			$lns = DefaultLanguage::getAcceptLanguage();
			$urlData = explode("/",self::getActualUrl());
			
			foreach($lns as $i => $ln){
				if(in_array($ln,$urlData)){
					self::$languageByUrl = $ln;
				}
			}
		}
		return self::$languageByUrl;
	}
	
	
	public static function getController() {

		$url = Http::server()->PATH_INFO;
		$ret =  explode ("/", $url);
		$ret = $ret[count($ret)-1];

		$controller = explode(".", $ret);
		if(strlen($controller[0]) == 0 ){
			return "DefaultController";
		}
		return $controller[0]."Controller";
	}


	public static function getAction() {

		$url = self::getUrlWithLanguage();
		$ret =  explode ("/", $url);
		$ret = $ret[count($ret)-1];

		$action = @explode(".", $ret);
		$temp = @explode("_",$action[1]);
		
		if(strlen(@$action[1]) == 0) return "defaultAction";		
		
		$temp2 = null;
		foreach($temp as $index => $t)	
			if($index == 0)
				$temp2 .= strtolower($t);
			else
		
				$temp2 .= ucfirst(strtolower($t));
			
		return $temp2."Action";
	}
	
	public static function getParams(){
		$data = null;
		
		if(is_array($_GET)){
			foreach($_GET as $k => $v){
				if($k == 'lang') continue;
				$data .= "$k=$v&";
			}
		}
		return $data;
	}
	
	public static function getFullUrl(){
		if((self::getParams()) == '')
			return self::getActualUrl();
		else return self::getUrlWithLanguage()."?". self::getParams();
	}
}
?>
