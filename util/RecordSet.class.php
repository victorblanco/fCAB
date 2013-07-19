<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class RecordSet extends Object {
    
   	private $filter = null;
	
	private $order = null;
	
	private $limit = null;
	
	protected $campos = "*";
		
    public function __construct(){
		parent::__construct();
    }
    
    public function __destruct() {
        unset($this);        
    }
    

	
	function setFields(HashTable $fields){
		$c = $fields->toArray();
		$this->campos = implode(",",$c);
 		return $this;	
	}
	public function setFilter(HashTable $filter){
		$this->filter = $filter;
		return $this;
	}
	
	public function getFilter(){
		return $this->filter;
	}
	
	public function setLimit(HashTable $limit){
		$this->limit = $limit;
		return $this;	
	}
	
	public function getLimit(){
		return $this->limit;	
	}
	

	protected function makeLimit(){
		
		if(is_object($this->limit) && $this->limit->count() != 0){
				return " LIMIT ".$this->limit->inferior.", ".$this->limit->superior." ";
		}
		return "";
	}
	
	protected function makeFilter(){
		$temp = null;
		if(is_object($this->filter) && $this->filter->count() != 0){
			
			foreach($this->filter as $campo => $valor){
				$temp .= " AND $campo ='".$valor."' ";
			}
		}
		return $temp;
	}
	
	
	public function setOrder(HashTable $order){
		$this->order = $order;	
		return $this;
	}
	
	public function getOrder(){
		return $this->order;	
	}
    
	protected function makeOrder(){
		$temp = " ";
		if(is_object($this->order) && $this->order->count() != 0){
			$temp = " ORDER BY ";
			foreach(@$this->order as $campo => $tipo){
				$temp .= " $campo $tipo ,";
			}
		}
		
		return substr($temp,0,strlen($temp) -1);
	}
	
	protected function makeQuery($value){
		 return  substr($value,0,(strlen($value)-2));
	}
}

