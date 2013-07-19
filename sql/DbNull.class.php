<?php


class DbNull extends FunctionsDb{
	protected $value ;

	public function getFunction( ){
		
		return " null ";
	}
	
}