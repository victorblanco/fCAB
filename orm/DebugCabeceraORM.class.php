<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class DebugCabeceraORM extends ActiveRecord {

	protected static $table = 'debugCabecera';

	protected  $fields = array(
			
			 'id'				=> 'id'
			 ,'ruta' 		=> 'ruta'
			 ,'get' 			=> 'get'
			 ,'post' 		=> 'post'
			 ,'session' 	=> 'session'
			 			 ,'phpsessionid'    => "phpsessionid" 
			
			);

	protected  $pkFields = array(
			'id'			
			
			);

	protected $values = array(
			
			 'id'					=> null
			 ,'ruta'				=> null
			 ,'get'				=> null
			 ,'post'				=> null
			 ,'session'			=> null
			 			 ,'phpsessionid'    => null 
			);
	
	public static function getTable(){
		return self::$table;
	}
	
	public static function getDS() {
		return App::getDS("DEBUG");
	}

	public static function getClass(){
		return __class__;
	}
	
	public static function getDefault(){
		$temp = self::getClass();
		return new $temp();
	}
}
