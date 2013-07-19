<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/

	
class ApplicationBase extends Object{

	protected static function run(){ 
		# iniciamos el log
		Log::ini(log_file);	
		# iniciamos el idioma
//		LogicLanguage::init();
		App::getDefault();
		App::setDS();
		App::getLocale();
		
		$ds = App::getDS();
		
		$ds->exec("set names utf8");	
		# iniciamos el timeZone
		Date::setDefaultTimezone("Europe/Madrid");
		
		# iniciamos el trace de performance
		Performance::start();
		
		Debug::startDebug();
		
		# Inicializamos la session
		$s = Session::getDefault();
		
		
					
	}
	
	public function __destruct(){
		
		unset($this);
	}
	
	
	/**
	*	@Description: Si tenenmos las indicaciones por get se pinta
	*	la performance y el debug	
	*
	*/
	protected static function end(){ 
		Performance::trace(App::get()->performance);
		$bytes  = Performance::memory();
		$mb		= $bytes / 1024 /1024;	
		Debug::add("Performance: Ficheros incluidos : " . count (Performance::files()) . " / Memoria: $bytes Bytes $mb Mb ");
		Log::write();
	}
}

