<?php


class NoTextDecorator extends Decorator implements IDecorator{

	public function  decorate($value){
		if($value){
			return $value;
		}else{
			$tpl = new Template("no_text_decorator.tpl");
			 
			return $tpl->parse();
		}
	}


}