<?php


class DbNow extends FunctionsDb{
	protected $value ;

	public function getFunction( ){
		
		return " now() ";
	}
	
}