<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class ControlPreviewImage extends Control {
	
	protected $text 	= null;
	
	protected $link  	= null;

	protected $image	= null;
	
	public function __construct(){
			parent::__construct();
			$this->setTpl("ControlPreviewImage.tpl");
	}

	public static  function getDefault(){
		return  new ControlPreviewImage();
	}
	
	public function setText($value){
			$this->text = $value;
			return $this;
	}

	public function setLink($value){
			$this->link = $value;
			return $this;
	}
	
	public function setImage($value){
			$this->image = $value;
			return $this;
	}

	public function parse(){
		parent::parse();
		
		$this->tpl->setVar("text", $this->text);
		$this->tpl->setVar("link", $this->link);
		$this->tpl->setVar("img",  $this->image);
		
		if(self::$js){ 
			$this->tpl->setVar("js", $this->tpl->parseBlock("JAVASCRIPT",1));
			$this->tpl->setVar("css", $this->tpl->parseBlock("CSSS",1));
			self::$js = false;
		}
		
		return $this->tpl->parse();
	}	
}

?>
