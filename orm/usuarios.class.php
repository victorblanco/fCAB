<?php


/**
 * AUTO-GENERATED. DO NOT MODIFY THIS FILE.
 * Package: ORM
 */
class usuarios extends ActiveRecord {

	protected static $table = '_usuarios';

	protected  $fields = array(
		
			 'id'				=> 'id'
			 ,'usuario'				=> 'usuario'
			 ,'descripcion'				=> 'descripcion'
			 ,'perfil'				=> 'perfil'
			 ,'password'				=> 'password'
			 ,"idLaboratorio"			=> 'id_laboratorio'
			 );

			 protected  $pkFields = array(
			 'usuario'
			 );

			 protected $values = array(
			 	
			 'id'				=> null
			 ,'usuario'				=> null
			 ,'descripcion'				=> null
			 ,'perfil'				=> null
			 ,'password'				=> null
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

?>
