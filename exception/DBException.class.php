<?php


class DBException extends Exception {
	function __construct($msg, $nerror = 0){
		Log::add("DBException: ". $msg);
		parent::__construct($msg, $nerror);
	}

}


?>