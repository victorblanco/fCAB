<?php


class DbMd5 extends FunctionsDb{
	protected $value ;
	function __construct( $value ){
		$this->value  = $value;
	}
	public function getFunction( ){
		
		return " md5('{$this->value}') ";
	}
	
}