<?php


class TranslatorRS extends RecordSet{

	private $className 		= null;
	
	private $language 	= null;
	
	private $varName	= null;
	

	
	function setClass($value){
		$this->className = $value;
		return $this;
	}
	
	
	function setLanguage($value){
		$this->language = $value;
		return $this;
	}
	
	
	function setVar($value){
		$this->varName = $value;
		return $this;
	}


	function sql(){
		
		$where = null;
		
		if(!is_null($this->className)){
			$where .= " and tra_var like '%".$this->className."%'";
		}
		
		if(!is_null($this->language)){
			$where .= " and tra_idi_id = '".$this->language."'";
		}
		
		if(!is_null($this->varName)){
			$where .= " and tra_var = '".$this->varName."'";
		}
	
	
		return "select * from traductor where 1 $where ".$this->makeOrder()." ".$this->makeLimit();
	}

}
?>
