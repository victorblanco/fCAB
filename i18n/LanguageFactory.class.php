<?php


class LanguageFactory  extends Object{


	public static function getDefault(){
		static $instance = array();
		
		$lang = Locale::getDefault()->getLocale();
		
		if(is_null(@$instance[$lang])){
			$class  = sprintf( 'Language_%s',  Locale::getDefault()->getLocale() );
			$instance[$lang] = new $class();
		}
		
		return $instance[$lang];
		
	}

}

