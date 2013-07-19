<?php


class SignedDecorator extends Decorator{
	
	function decorate( $value ){
		if (is_numeric($value) ){
			if ($value < 0){
				$tpl = new Template("signed.tpl");
				$tpl->setVar("value", $value);
				return $tpl->parse();
			}
		}
		
		return $value;
	}
	
	
}