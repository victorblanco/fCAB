<?php


class AdminBreadCrumbOU extends Output{
	
	protected $bc;
	
	public function getOutput(){
		
		$tpl = new Template("adminbreadcrumb.tpl");
		
		$this->bc = AdminBreadCrumbLogic::getBC();
		
		$separator = $tpl->parseBlock("SEPARATOR");
		
		$breadcrumb = $tpl->parseBlock("INICIO").$separator;
		for($i=0;$i<count($this->bc) -1;$i++){
			$tpl->setVarBlock("ENTRADA_LINK","url",$this->parseEntrada($this->bc[$i]));
			$tpl->setVarBlock("ENTRADA_LINK","title",$this->bc[$i]['title']);
			
			$breadcrumb .= $tpl->parseBlock("ENTRADA_LINK").$separator;
		}
		$tpl->setVarBlock("ENTRADA","title",$this->bc[count($this->bc)-1]['title']);
		$breadcrumb .= $tpl->parseBlock("ENTRADA");
		
		return $tpl->setVar("breadcrumb",$breadcrumb)->parse();
	}
	
	
	protected function parseEntrada($entrada){
		
		$controller = str_replace("Controller","",$entrada['controller']);
		$action = str_replace("Action","",$entrada['action']);
		
		$params = "";
		if(is_array($entrada['params'])){
			
			foreach($entrada['params'] as $key => $value){
				$params.=$key.'='.$value.'&';
			}
			$params = substr($params,0,-1);
		}
		
		return "app/$controller.$action?$params";
	}
	
}