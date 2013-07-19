<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class DebugORM extends ActiveRecord {

	protected static $table = 'debug';

	protected  $fields = array(
			
			 'id_debug'				=> 'id_debug'
			 ,'id'				=> 'id'
			 ,'txt'				=> 'txt'
			 ,'tipo'				=> 'tipo'
			 ,'backtrace'				=> 'backtrace'
			 ,'app'				=> 'app'
			 ,'time'  			=> 'time'
		
			);

	protected  $pkFields = array(
		  0          => 'id_debug'	
			
			);

	protected $values = array(
			'id_debug'          => null,	
			 'id'				=> null
			 ,'txt'				=> null
			 ,'tipo'				=> null
			 ,'backtrace'				=> null
			 ,'app'				=> null
			,'time'				=> null
			
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
