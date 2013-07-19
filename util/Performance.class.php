<?php 
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class Performance extends Object{
	
	private static $time;

	static  function start(){
		self::$time = microtime();
	}	
	
	static function files(){
		return get_required_files();
	}
	
	static function timer(){
		return microtime() - self::$time;
	}
	
	static function memory(){
		return memory_get_usage(true);
	}
	
	static function trace($value = false){
		if ($value == true){
			echo "<table style='width:1000px; background-color:#B0C5FF; border:1px solid black; font:normal 11px/11px Courier New; margin:2px;'>";
			if(is_array(Performance::files())){
				echo "<tr><td><b>Require Files:</b> </td></tr>";
				foreach (Performance::files() as $key => $value){
					echo "<tr><td>".(int)($key+1).") $value </td></tr>";
				}
			}
			echo "<tr><td> <br /><b>Require Time:</b>".Performance::timer()." Segundos </td></tr>";
			echo "<tr><td><b>Require Memory:</b>".Performance::memory()." Bytes <br /></td></tr>";
			echo "</table>";
		}
	}
	
}
