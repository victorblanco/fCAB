<?php

class ControlImages extends Control{
	protected $imgs = "";
	
	public function __construct(){
		parent::__construct();
		$this->setTpl("ControlImages.tpl");
	}
	
	public function addImg($ruta, $alt){
		$this->tpl->setVarBlock("IMG","ruta_img", $ruta);
		$this->tpl->setVarBlock("IMG","alt", $alt);
		$this->imgs .= $this->tpl->parseBlock("IMG");
	}
	
	public function parse(){
		$this->tpl->setVar("imgs", $this->imgs);
		return $this->tpl->parse();
	}
}