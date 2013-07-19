<?php 

/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: V�ctor Blanco
 *	Date:
 *	Company:
 */
class App extends Object{

	private static $data = array();
	protected static $conf;
	protected static $db;
	protected static $tmp;
	protected static $get;
	protected static $post;
	protected static $server;
	protected static $global;
	protected static $request;
	protected static $translator;
	protected static $translators = array();

	public function __construct(){
		self::$conf 	= new Xml(self::getConfigFile());
		self::$db	 	= new Xml(self::getDBFile());
		self::$get 		= new HashTable($_GET);
		self::$global	= new HashTable($GLOBALS);
		self::$post 	= new HashTable($_POST);
		self::$server 	= new HashTable($_SERVER);
		self::$request 	= new HashTable($_REQUEST);
		
	}
	
	static function getConfigFile(){
		if (file_exists(CONF."CONF_".ENTORNO.".xml")){
			return CONF."CONF_".ENTORNO.".xml";
		}else{
			return CONF."CONF.xml";
		}
	}
	static function getDBFile(){
		if (file_exists(CONF."DB_".ENTORNO.".xml")){
			return CONF."DB_".ENTORNO.".xml";
		}else{
			return CONF."DB.xml";
		}
	}
		

	public static function get(){
		return self::$get;
	}

	public static function getEntornos(){
		if (App::isConsole())	{
			return array_merge(App::globals()->ENTORNOS_CONSOLE, App::globals()->ENTORNOS );
		}else{
			return App::globals()->ENTORNOS;
		}
	}

	public static function post(){
		return self::$post;
	}

	public static function server(){
		return self::$server;
	}

	public static function globals(){
		return self::$global;
	}
	public static function request(){
		return self::$request; 
	}
	public static function unSanitizeRequest(){
		return self::$request;
	}
	
	public static function setRequest(){
		if(!get_magic_quotes_gpc()){
			foreach($_REQUEST as $key => $value){
				//$_REQUEST[$key] = addslashes($value);
			}
		}
		return $_REQUEST; 
	}
	
	public static function getDefault(){
		static $instance = null;
		if(is_null($instance)){
			$instance = new App();
		}
		return $instance;
	}
	
	public static function isITT(){
		return Session::get("_ITT_")?true:false;
		
	}

	public static function getCONF(){
		self::$tmp = new HashTable();

		if (!count($tmp)) {
			$i = self::$conf->getIterator();
			foreach($i->item as $item){
				$name = $item['name'];
				self::$tmp->$name =  (string)$item['value'];
			}

		}
		return self::$tmp;
	}
	public static function setDS(){
		$i = self::$db->getIterator();
		foreach($i->item as $item)  {
			try{
				if( (string)$item["active"] != "false" ){
					$driver = (string)$item["phptype"];
					$n = $item["name"];
					self::$data["DBOBJECT"]["$n"] = new $driver(
					(string)$item["database"],	(string)$item["host"],
					(string)$item["usser"],	(string)$item["password"]);
					self::$data["DBOBJECT"]["$n"]->connect();
					Debug::add("APP: Conectando " .(string)$item["name"] ."(" .$item["phptype"] . ")" );
				}
			}catch(Exception $e){
				Log::add($e);
				throw new Exception("Error en la carga del Driver ($n). " .  $e->getMessage());
			}
		}
	}
	public static function getDS( $name = "DEFAULT"){
		if ( !is_null(@self::$data["DBOBJECT"][$name]) ) {
			return self::$data["DBOBJECT"][$name];
		}elseif(!is_null(@self::$data["DBOBJECT"]["DEFAULT"])){
			return self::$data["DBOBJECT"]["DEFAULT"];
		}
		throw new Exception("No se ha definido el DS [$name] en el XML DB.xml");

	}
	public static function getController() {

		$url = App::server()->PATH_INFO;
		$ret =  explode ("/", $url);
		$ret = $ret[count($ret)-1];

		$controller = explode(".", $ret);
		if(strlen($controller[0]) == 0 ){
			return "DefaultController";
		}
		return $controller[0]."Controller";
	}

	public static function isConsole(){
		if (strpos(App::server()->SCRIPT_FILENAME,"index_console.php" )!== false){
			return true;
		}else{
			return false;
		}
	}

	public static function getAction() {

		$url = App::server()->PATH_INFO;
		$ret = explode ("/", $url);
		$ret = $ret[count($ret)-1];

		$action = @explode(".", $ret);
		//$temp 	= @explode("_",$action[1]);

		if(strlen(@$action[1]) == 0) return "defaultAction";
		else return $action[1]."Action";
//		$temp2 = null;
//		foreach($temp as $index => $t)
//		if($index == 0)
//		$temp2 .= strtolower($t);
//		else
//
//		$temp2 .= ucfirst(strtolower($t));
//			
//		return $temp2."Action";
	}

	public static function redirect($ruta){
		header("Location: ".SUB_CARPETA."$ruta");
		die();
	}

	public static function getAllDS(){
		return self::$data["DBOBJECT"];
	}

	public static function getLocale(){
		if (Session::get("LOCALE")){
			return Session::get("LOCALE");
		}else{
			$ruta = explode ("/",RUTA_APP);
			$idioma = $ruta[0];
			$soportados=App::getLocales();

			if (in_array($idioma, $soportados)){
				Session::set("LOCALE", $idioma);
				return $idioma;
			}else{
				App::setLocale($soportados[0]);
			}
		}
	}
	public static function getLocales(){
		$locales = App::getCONF()->locales;
		if ($locales != ""){
			return explode(",", $locales);
		}
		throw new Exception("La aplicacion no soporta ning�n locale.");
	}
	
	public static function setLocale($locale){
		$ruta = explode ("/",RUTA_APP);
		$soportados=App::getLocales();
		if (!in_array($locale, $soportados)){
			throw new Exception("Locale $locale no soportado");
		}
		if (in_array($ruta[0], $soportados)){
			$ruta[0] = $locale;
		}
		
		Session::set("LOCALE", $locale);
		App::getTranslator(null, true);
	}


	public function __destruct(){
		unset($this);
	}

	public static function getTranslator($domain = null, $recargar = false){
		if (is_null($domain)) $domain = App::getController();
		
		if (!self::$translators[$domain] || $recargar){
			self::$translators[$domain] 	=  new DBTranslator();
			self::$translators[$domain]->setDomain($domain);
		}
		return self::$translators[$domain];
		
	}

}
