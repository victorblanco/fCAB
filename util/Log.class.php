<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Log extends Object{

	private static $logFile;
	private static  $data = array();
	
	public static function ini($logFile){
		self::$logFile = $logFile;
	}


	public static function add($e){
		if (is_object($e)){
			//if (strtolower(get_class($e)) === "exception")
				self::$data [] = $e->getMessage();
				Debug::add($e->getMessage());
		}else{
			self::$data [] = $e;
			Debug::add($e);
		}

	//	self::write();
	}
	
	/**
	*	@Description: Este método le pide al objeto statico Debug lo mensajes
	*	Itera en todos ellos y comprueba si existe la palabra error en dichos mensajes
	*	Si es encontrada la palabra procede a escribir en el fichero de log dicho error
	*/
	public static function write(){

		$fecha = date("d-m-Y H:i:s");
	
		$separate = "\n\n".$fecha ." _________________________________________________________________________\n";
		
		$f = new FileWriter(self::$logFile);
		
		$debug = Debug::getErrors();
		if( count($debug) > 0){
			foreach ($debug as $txt => $a){
				if(stripos($txt,"ERROR") !== false)
					$f->write($separate.$txt,"a+");
			}
		}
	
		if(count(self::$data) > 0 ){
			foreach (self::$data as $txt){
				$f->write($separate.$txt,"a+");
			}
		}
	}
}


