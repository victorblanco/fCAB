<?php 


class Debug  extends Object{

	private static $data = array();
  	public static $id;	
	private static $performance = false;
	static	$time;
	static	$totalTime;
	
	static function add($value){
		$m 				 = microtime();
		$mt 			 = microtime() - self::$time;
		self::$time		 =  $m;
		self::$totalTime+=  (double)$mt;
		$txt = sprintf("Time:  %.5f, Acumulado:  %.5f", microtime() - self::$time, (double)self::$totalTime);
		self::saveBD($value , "LOG", $txt);
		if (App::isConsole() && App::request()->debug == 1){
			echo "$value $txt\r\n";
		}		
	}
	static function addQuery($value, $time){
		self::saveBD($value , "SQL", sprintf("Time: %.5f", $time));
		if (App::isConsole() && App::request()->debug == 1){
			echo "$value : SQL" . sprintf("Time: %.5f", $time) ."\r\n";
		}		
	}
	
	static function startDebug(){
		if (Session::get("_DEBUG_")){	
			self::$time		 	=  microtime();
			self::$totalTime 	=0;
			$debug 				= DebugCabeceraORM::getDefault();
			$debug->ruta		= $_SERVER['REQUEST_URI'];
			$debug->get			= base64_encode(serialize($_GET));
			$debug->session		= base64_encode(serialize($_SESSION));
			$debug->post 		= base64_encode(serialize($_POST));
			$debug->phpsessionid= session_id() ;
			
			$debug->insert();
			self::$id = $debug->id;
		}
	}
	
	
	static function saveBD($value, $type, $time = 0){
		
		if (Session::get("_DEBUG_")){
			try{
				$debug 				= DebugORM::getDefault();
				$debug->id  		= self::$id;
				$debug->txt 		= $value;
				$debug->tipo		= $type;
				$debug->app 		= APPNAME;
				$debug->time		= $time;
				$debug->backtrace 	= base64_encode(serialize(debug_backtrace()));
				$debug->insert();
			}catch(Exception $e){
				//var_dump($e);
			}

		}
	}

	static function setPerformance($value = false){
		self::$performance = $value;
	}

	static function get(){
		return self::$data;
	}

	public static function getErrors($type = 2, $mode = "\n"){
		return @self::$data[$type];
	}
	
	public static function addBackTrace($type = 2){
	//	self::$data[$type][] = self::getTrace( debug_backtrace());
	}
	
	public static function save($type =2){
		Session::set("DEBUG",serialize(self::$data[$type]));
	}
	
	public static function getTrace($trace){
		$temp = "<table width='100%'>";
		foreach ($trace as $t){
			$temp .= "<tr><td>".$t['file']."</td><td>".$t['line']."</td><td>".$t['function']."</td></tr>";
		}
		$temp .= "</table>";
		return $temp;
	}
	
	public static function loadDebug(){
		return unserialize(Session::get("DEBUG"));
	}
	
	public static function loadDebugSerialize(){
		return Session::get("DEBUG");
	}

	public static function trace($level = 0){

		$trace = array();

		if ( (int)$level > 1){
			$trace = self::getErrors($level, "<br/>");
		}
		if (count($trace)>0){
			echo "<table style='width:1000px; background-color:#B0C5FF; border:1px solid black; font:normal 11px/11px Courier New; margin:2px;'>";
			foreach ($trace as $value){ 
				echo "<tr><td>$value</td></tr>";
			}
			echo "</table>";
		}
		
	}

}
