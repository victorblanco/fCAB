<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Http {

	public static $get;
	public static $post;
	public static $server;
	public static $r;
	
	private static $data = array();


	public function __construct(){
		self::$get = new HashTable($_GET);
		self::$post = new HashTable($_POST);
		self::$server = new HashTable($_SERVER);
		self::$r = new HashTable($_REQUEST);
	}
	
	public static function get(){
		Debug::add("LLamada Deprecate");
		return self::$get;
	}
	
	public static function post(){
		Debug::add("LLamada Deprecate");
		return self::$post;
	}
	
	public static function server(){
		Debug::add("LLamada Deprecate");
		return self::$server;
	}

	public static function r(){
		Debug::add("LLamada Deprecate");
			return self::$r;
	}

	public static function getDefault(){
		return new Http();
	}




}


?>
