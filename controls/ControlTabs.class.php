<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class ControlTabs extends Control {
	

	protected $data = array();
	
	public function __construct(){
			parent::__construct();
			$this->setTpl("ControlTabs.tpl");
	}

	public static  function getDefault(){
		return  new ControlTabs();
	}
	
	public function addTab($title, $content){
			$this->data[$title] = $content;
			return $this;
	}


	public function parse(){

		parent::parse();
	
		if(count($this->data) == 0) return ""; 

		$temTitle 	 	= null;
		$tempContsnt 	= null;
		$tabs 			= "";
		$i			 = 1;
		foreach($this->data as $title => $content){
			$this->tpl->setVarBlock("TABS", "content", $content)->setVarBlock("TABS", "i", $i);
			$tabs .= $this->tpl->setVarBlock("LINK_TABS", "i", $i)
						->setVarBlock("LINK_TABS", "content", $title)
						->parseBlock("LINK_TABS");
			$this->names .= "'$title',";

			$tempContsnt 	.= $this->tpl->parseBlock("TABS",1);
			$i ++;
		}

		$this->tpl->setVar("tabs",$tabs);
		$this->tpl->setVar("tabs_content",$tempContsnt);
		$this->tpl->setVar("name",$this->name);
		$this->tpl->setVar("names",substr($this->names,0,-1));
		if(self::$js){ 
			$this->tpl->setVar("js", $this->tpl->parseBlock("JAVASCRIPT",1));
			$this->tpl->setVar("css", $this->tpl->parseBlock("CSSS",1));
			self::$js = false;
		}

		
		return $this->tpl->parse();
	}	
}


