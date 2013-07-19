<?php


class ParamsException extends GenException {
	function __construct($msg, $nerror){
		Debug::add("ParamsException: ".$msg );
		parent::__construct($msg, $nerror);
	}

}


