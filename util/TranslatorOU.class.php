<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class TranslatorOU extends Object{

	
	public static function tpl(Template $tpl, $class){
		
		try{
		
			$db = App::getDS("DEFAULT");
			
			$rs = new TranslatorRS();
			$rs->setClass($class);
			$rs->setLanguage(DefaultLanguage::getLanguage());
			
			$ex = $db->exec($rs->sql());

			while ($rd = $db->next($ex)){
				$tpl->setVar($rd->tra_var,$rd->tra_value);
			}
			
			$db->free($ex);
			
			return $tpl;
			
		}catch(Exception $e){
			Debug::add($e->getMessage());
		}
	
	}

	
	public static function varBlock(Template $tpl, $block, $var){
		
		try{
		
			$db = App::getDS("DEFAULT");
			
			$rs = new TranslatorRS();
			$rs->setVar($var);
			$rs->setLanguage(DefaultLanguage::getLanguage());
			
			$ex = $db->exec($rs->sql());
			
			while ($rd = $db->next($ex)){
				$tpl->setVarBlock($block, $var , $rd->tra_value);
			}
			
			$db->free($ex);
			
			return $tpl;
			
		}catch(Exception $e){
			Debug::add($e->getMessage());
		}
	
	}

}
?>
