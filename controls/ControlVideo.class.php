<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class ControlVideo extends Control {
	
	protected $data 	= array();

	
	public function __construct(){
			parent::__construct();
			$this->setTpl("ControlVideo.tpl");
	}

	public static  function getDefault(){
		return  new ControlVideo();
	}
	
	public function addVideo($video, $text){
			$this->data[$video] = $text;
			return $this;
	}

	public function parse(){
		parent::parse();
		
		if(is_null($this->name)) throw new Exception("No se ha seteado el name");
		
		$temp = null;
		foreach ($this->data as $video => $text ) {
		
			$this->tpl->setvarBlock("ROW","text", $text);
			$this->tpl->setvarBlock("ROW","video", $video);
			$this->tpl->setvarBlock("ROW","name", $this->name);
			$this->tpl->setVar("video",  $video);
			$temp .=  $this->tpl->parseBlock("ROW",1);
		}

		
		$this->tpl->setVar("rows",  $temp);
		
		if(self::$js){ 
			$this->tpl->setVar("js", $this->tpl->parseBlock("JAVASCRIPT",1));
			$this->tpl->setVar("css", $this->tpl->parseBlock("CSSS",1));
			self::$js = false;
		}
		
		return $this->tpl->parse();
	}	
}

?>
