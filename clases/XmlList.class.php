<?php


class XmlList extends Output{
	protected $xml;
	
	function __construct(){

	}
	
	function setXml($xml){
		$this->xml = $xml;
		return $this;
		
	}
	
	function save(){
		$xml 	= new XML($this->xml);
		$x 	= $xml->getIterator();
				
		foreach ($x->item as $key => $item){
			$item['value'] = App::request()->$item['name'];
		}
		$xml->setIterator($x)->save();
	}	
	function getOutput(){
		$x 	= new XML($this->xml);
		$xml 	= $x->getIterator();

		$tpl = new Template("xmlList.tpl", tpl_dir, tpl_pre);
		$tmp = "";
		foreach ($xml->item as $key => $item){
			$tpl->setVarBlock("LINE","description",$item['name']);
			$tpl->setVarBlock("LINE","name",$item['name']);
			$tpl->setVarBlock("LINE","value",$item['value']);
			$tpl->setVarBlock("LINE","comment",$item['comment']);
			if((string)$item['comment']!=""){
				$tpl->setVarBlock("LINE","info", $tpl->parseBlock("INFO"));
			}else{
				$tpl->setVarBlock("LINE","info","");
			}
			$tmp .= $tpl->parseBlock("LINE");
		}
		$tpl->setVar("line", $tmp);
		
		return $tpl->parse();
	}
}
