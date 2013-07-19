<?php

class ControlButton extends Control{
	private $alt;
	private $img;
	private $action;
	private $width = 26;
	private $height = 22;
protected $preloadImg="";
	public function __construct() {
		try{
		parent::__construct();
		
		$this->setTpl("ControlButton.tpl");
		}catch(Exception $e){
			var_dump($e);
		}

	}
	public static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ControlButton();

		return $i;
	}
	public function setWidth($w) {
		$this->width = $w;
		return $this;
	}
	
	public function setHeight($h){
		$this->height= $h;
		return $this;
	}

	public function setMiniButton(){
		return $this;
	}
	
	public function addButton ($name , $img, $action ,$alt, $cargando = 0){
		
		$this->name = $name;
		$this->img = $img;
		$this->img2 = $img; //$this->imgSustitucion($img);
		$this->action = $action;
		$this->alt = $alt;
		return $this;
	}
	public function parse(){
		
		parent::parse();
		
		$this->tpl->setVar("width",$this->width);
		$this->tpl->setVar("height",$this->height);
		$this->tpl->setVar("img",$this->img);
		$this->tpl->setVar("img2",$this->img2);
		$this->tpl->setVar("action",$this->action);
		$this->tpl->setVar("alt",$this->alt);
		$this->preloadImg .= "'".$this->img2."',";
		return $this->tpl->parse();
	}
	public function getPreloadImg(){
		return substr($this->preloadImg, 0, -1);
	}
	
	private function imgSustitucion ($img){
		$comp = explode(".", $img);
		if (count($comp) == 2){
		return $comp[0]."_.".$comp[1];
		}else{
			Debug::add("Boton cargado sin img de Sustitucion solo tiene ".count($comp)." parte");
		} 

	}

}


?>
