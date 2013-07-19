<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class AdminTablas extends ActiveRecord {

	protected static $table = 'admin_tablas';

	protected  $fields = array(
			
			 'idTabla'				=> 'id_tabla'
			 ,'description'				=> 'description'
			 ,'nombreAdmin'				=> 'nombre_admin'
			 ,'columnas'				=> 'columnas'
			 ,'columnasLista'				=> 'columnas_lista'
			 ,'campoDescriptor'			=> 'campo_descriptor'
			 ,'js'				=> 'js'
			 ,'pModify'				=> 'p_modify'
			 ,'pView'				=> 'p_view'
			 ,'pDelete'				=> 'p_delete'
			 ,'pAdd'				=> 'p_add'
			
			);

	protected  $pkFields = array(
			
			 'idTabla'
			
			);

	protected $values = array(
			
			 'idTabla'				=> null
			 ,'description'				=> null
			 ,'nombreAdmin'				=> null
			 ,'columnas'				=> null
			  ,'columnasLista'				=> null
			  ,'campoDescriptor'			=> null
			 ,'js'				=> null
			 ,'pModify'				=> null
			 ,'pView'				=> null
			 ,'pDelete'				=> null
			 ,'pAdd'				=> null
			
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
