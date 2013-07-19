<?php


class TemplateException extends GenException {
	function __construct($msg, $nerror = 0 ){
		Log::add("TemplateException: " . $msg);
		parent::__construct($msg, $nerror);
	}

}


