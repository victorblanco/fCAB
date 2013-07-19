<?php
class UserLogic extends Object{
	
	static function isLogged(){
		return true;
	}
	
	static function isAllowedItt(){
		return true;
	}
	
	static function isAllowedDebug(){
		return true;
	}
	
	static function isAllowedConfig(){
		return true;
	}
	
	static function isAllowedAdmin(){
		return true;
	}
	
	static function isAllowedUtils(){
		return true;
	}
	
	static function notAllowed(){
		App::redirect("redirect.php");
		return true;
	}
}