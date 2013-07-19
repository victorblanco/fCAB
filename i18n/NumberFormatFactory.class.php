<?php


class NumberFormatFactory  extends Object{


	public static function getDefault(){
		static $instance = array();
		
		$lang =  App::getLocale();
		
		if(is_null(@$instance[$lang])){
			$class  = sprintf( 'NumberFormat_%s',  App::getLocale() );
			$instance[$lang] = new $class();
		}
		
		return $instance[$lang];
		
	}

}

