<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class LogicLanguage {



	public static function  init(){
		
//		URL::makeSlash();
			
		if(!is_null(Http::$get->lang)){
			DefaultLanguage::setLanguage(Http::get()->lang);
			
			/*if(URL::hasLanguageInUrl()){
				if(URL::getLanguageByUrl() != Http::get()->lang){
					header("Location:" . URL::replaceLanguage(URL::getLanguageByUrl(),Http::get()->lang));
				}
			}*/
		}
		
		
/*		# cuando se accede por el indice de los motores debo setear 
		# el idioma en funcion a la url
		if(URL::hasLanguageInUrl()){
			DefaultLanguage::setLanguage(URL::getLanguageByUrl());
		}
		
		
		if( !URL::hasThisLanguageInUrl(DefaultLanguage::getLanguage())){
			URL::redirectLanguage(DefaultLanguage::getLanguage());
		}*/
		
	}


}

?>
