<?php


class GenException extends Exception {
	protected $nerror; 
	function __construct($msg, $nerror  = 0 ){
		$this->nerror = $nerror;
		Debug::add("GenException: ". $msg);
		parent::__construct($msg);
	}
	
	public function getError(){
		return $this->nerror;
	}

}


