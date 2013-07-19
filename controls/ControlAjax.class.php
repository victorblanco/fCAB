<?php

class ControlAjax extends Control{
	protected $disparador;
	protected $event;
	protected $function_ini;
	protected $divLoading;
	protected $url;
	protected $extra;
	protected $type = "GET";
	protected $function_fin;
	protected $divResponse;
	protected $loading;
	
	public function __construct(){
		$this->setTpl("ControlAjax.tpl");
	}
	
	public function setDisparador($disparador, $event){
		$this->disparador 	= $disparador;
		$this->event 		= $event;	
		return $this;
	}
	public function setType($type){
		$this->type  = $type;
		return $this;
	}
	
	public function setfunction($inicio, $fin){
		$this->function_ini 	= $inicio;
		$this->function_fin	= $fin;
 		return $this;
	}
	
	public function setDivLoading($divLoading,$loading){
		$this->divLoading = $divLoading;
		$this->loading = $loading;
		return $this;
	}
	
	public function setURL($url){
		$this->url = $url;
		return $this;
	}
	
	public function setExtraAjax($extra){
		$this->extra = $extra;
		return $this;
		
	}
	
	public function setResponse($response, $atributo = "innerHTML"){
		$this->divResponse 	= $response;
		$this->atributo		= $atributo;
		return $this;
	}
	
	public function parse(){
		parent::parse();
		if ($this->divLoading){
			$this->tpl->setVarBlock("LOADING","divLoading",$this->divLoading);
			$this->tpl->setVarBlock("LOADING","loading",$this->loading);
			$this->tpl->setVar("loading_", $this->tpl->parseBlock("LOADING"));
		}
		$this->tpl->setVar("url", $this->url);
		$this->tpl->setVar("extra", $this->extra);
		$this->tpl->setVar("type", $this->type);
		$this->tpl->setVar("response", $this->divResponse);
		$this->tpl->setVar("atributo", $this->atributo);
		$this->tpl->setVar("disparador", $this->disparador);
		$this->tpl->setVar("event", $this->event);
		$this->tpl->setVar("function_ini", $this->function_ini);
		$this->tpl->setVar("function_fin", $this->function_fin);
		return $this->tpl->parse();
	}
	
}
