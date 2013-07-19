<?php


/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/
class Traductor extends ActiveRecord {

	protected static $table = 'traductor';

	protected  $fields = array(
			
			 'key_'				=> 'key_'
			 ,'domain'				=> 'domain'
			 ,'txt'				=> 'txt'
		
			);

	protected  $pkFields = array(
			 'key_'	
			 ,'domain'
			);

	protected $values = array(
			 'key_'				=> null
			 ,'domain'			=> null
			 ,'txt'				=> null
			
			);
	
	public static function getTable(){
		return self::$table. "_" . App::getLocale();
	}
	public static function getTableByLocale(){
		return self::$table . "_" . App::getLocale();	
		
	
	}
	
	public static function getDS() {
		return App::getDS("i18n");
	}

	public static function getClass(){
		return __class__;
	}
	

	public static function getDefault(){
		$temp = self::getClass();
		return new $temp();
	}
}

?>
