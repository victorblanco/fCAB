<?php


class DateFormatFactory  extends Object{


	public static function getDefault(){
		static $instance = array();
		
		$lang = App::getLocale();
		if(is_null(@$instance[$lang])){
			$class  = sprintf( 'DateFormat_%s',  App::getLocale() );
			$instance[$lang] = new $class();
		}
		
		return $instance[$lang];
		
	}

}

