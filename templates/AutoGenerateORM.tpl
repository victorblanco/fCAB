<?php

/**
* AUTO-GENERATED. DO NOT MODIFY THIS FILE.
* Package: ORM
*/

class <!-- {clase} --> extends ActiveRecord {

	protected static $table = '<!-- {table} -->';

	protected  $fields = array(
			<!-- @ FIELD @ --> <!-- {coma} -->'<!-- {name} -->'				=> '<!-- {dbname} -->'
			<!-- @ FIELD @ -->
			<!-- {fields} -->
			);

	protected  $pkFields = array(
			<!-- @ PK @ --> <!-- {coma} -->'<!-- {name} -->'
			<!-- @ PK @ -->
			<!-- {pks} -->
			);

	protected $values = array(
			<!-- @ VALUE @ --> <!-- {coma} -->'<!-- {name} -->'				=> null
			<!-- @ VALUE @ -->
			<!-- {values} -->
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
