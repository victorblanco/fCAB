<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class AdminBotonera extends ActiveRecord {

	protected static $table = 'admin_botonera';

	protected  $fields = array(
			
			 'idBotonera'				=> 'id_botonera'
			 ,'idTabla'				=> 'id_tabla'
			 ,'icono'				=> 'icono'
			 ,'url'				=> 'url'
			 ,'parametros'				=> 'parametros'
			 ,'caption'				=> 'caption'
			 ,'visibleLista'				=> 'visible_lista'
			 ,'visibleDetalle'				=> 'visible_detalle'
			
			);

	protected  $pkFields = array(
			
			 'idBotonera'
			
			);

	protected $values = array(
			
			 'idBotonera'				=> null
			 ,'idTabla'				=> null
			 ,'icono'				=> null
			 ,'url'				=> null
			 ,'parametros'				=> null
			 ,'caption'				=> null
			 ,'visibleLista'				=> null
			 ,'visibleDetalle'				=> null
			
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
