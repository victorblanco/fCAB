<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class AdminTiposCampos extends ActiveRecord {

	protected static $table = 'admin_tipos_campos';

	protected  $fields = array(
			
			 'idTipoCampo'				=> 'id_tipo_campo'
			 ,'description'				=> 'description'
			 ,'extra'				=> 'extra'
			
			);

	protected  $pkFields = array(
			
			 'idTipoCampo'
			
			);

	protected $values = array(
			
			 'idTipoCampo'				=> null
			 ,'description'				=> null
			 ,'extra'				=> null
			
			);
	
	public static function getTable(){
		return self::$table;
	}
	
	public static function getDS() {
		return App::getDS("DEFAULT");
	}

	public static function getClass(){
		return __class__;
	}
	
	public static function getDefault(){
		$temp = self::getClass();
		return new $temp();
	}
}
