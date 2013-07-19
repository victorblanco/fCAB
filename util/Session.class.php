<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class Session{

	static $sess;

	/**
	*
	*
	*/
	private function __construct(){
		@session_start();
	}

	public static function getDefault(){
		if( is_null(self::$sess)){
			self::$sess = new Session();
		}
		return self::$sess;
	}


	/**
	*
	*
	*/
	public static function isRegister($name){
		return isset($_SESSION[$name]);
	}

	/**
	*
	*
	*/
	public static function register($name){
		return session_register($name);
	}

	/**
	*
	*
	*/
	public static function unregister($name){
		unset($_SESSION[$name]);
	}

	public static function logoutSession(){
		return session_destroy();
	}
	/**
	*
	*
	*/
	public static function set($name,$value){
		return $_SESSION[$name]=$value;
	}

	/**
	*
	*
	*/
	public static function get($name){
   		return $_SESSION[$name];
	}

	/**
	*
	*
	*/
	public static function getId(){
    	return $_REQUEST['PHPSESSID'];
	}


	public static function delete($name = null){
		if(is_null($name))	session_unset();
		self::unregister($name);
	}


	/**
	*
	*
	*/
	public static function serialize($name,$value){
		$temp=serialize($value);
		return $_SESSION[$name]=$temp;
	}

	/**
	*
	*
	*/
	public static function unserialize($name){
		return unserialize($_SESSION[$name]);
	}


	public static function dump() {
		$str = sprintf( "Session: %s\n%s\n", $_REQUEST['PHPSESSID'], str_repeat( '-', 41 ) );
		foreach( $_SESSION as $name => $value ) {
			if ( !is_object( $value ) ) {
				$str.= sprintf( "%-20s -> %s\n", $name, $value );
			} else {
				$str.= sprintf( "%-20s -> Object ID# %s\n", $name.' ('.get_class( $value ).')', $value->id() );
			}
		}
		return $str;
	}
}

