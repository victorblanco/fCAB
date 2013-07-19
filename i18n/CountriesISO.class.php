<?php

/**
 * Contiene la correspondencia entre c�digos de pa�ses y sus nombres seg�n el est�ndar ISO 3166-1 alfa-2
 * @author fernando
 *
 */
class CountriesISO extends Locale{
	
	
	public static function getDefault(){
		static $instance = array();
		
		$lang = App::getLocale();
		if(is_null(@$instance[$lang])){
			$class  = sprintf( 'CountriesISO_%s',  App::getLocale() );
			$instance[$lang] = new $class(App::getLocale());
		}
		
		return $instance[$lang];
		
	}
}
