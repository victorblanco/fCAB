<?php


class AdminBodyOU extends Output{
	
	public function getOutput(){
		AdminBreadCrumbLogic::addBC("Inicio",0);
		
		$tpl = new Template("admin_body.tpl");
		
		return $tpl->parse();
	}
}