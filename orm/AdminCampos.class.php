<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class AdminCampos extends ActiveRecord {

	protected static $table = 'admin_campos';

	protected  $fields = array(
			
			 'idCampo'				=> 'id_campo'
			 ,'nombre'				=> 'nombre'
			 ,'descripcion'				=> 'descripcion'
			 ,'idTabla'				=> 'id_tabla'
			 ,'idTipoCampo'				=> 'id_tipo_campo'
			 ,'extra'				=> 'extra'
			 ,'action'				=> 'action'
			 ,'js'				=> 'js'
			 ,'ordenLista'				=> 'orden_lista'
			 ,'ordenDetalle'				=> 'orden_detalle'
			 ,'ordenBusqueda'				=> 'orden_busqueda'
			 ,'claseValidador'				=> 'clase_validador'
			 ,'alineacion'				=> 'alineacion'
			
			);

	protected  $pkFields = array(
			
			 'idCampo'
			
			);

	protected $values = array(
			
			 'idCampo'				=> null
			 ,'nombre'				=> null
			 ,'descripcion'				=> null
			 ,'idTabla'				=> null
			 ,'idTipoCampo'				=> null
			 ,'extra'				=> null
			 ,'action'				=> null
			 ,'js'				=> null
			 ,'ordenLista'				=> null
			 ,'ordenDetalle'				=> null
			 ,'ordenBusqueda'				=> null
			 ,'claseValidador'				=> null
			 ,'alineacion'				=> null
			
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
