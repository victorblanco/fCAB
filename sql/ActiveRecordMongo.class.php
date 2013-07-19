<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class ActiveRecordMongo  extends ActiveRecord{

	public function getByIdMongo( $id ){
		$conn 		= $this->getDS();
		$tabla		= $this->getTable();
		$pk			= array();

		$valores =  $conn->$tabla->findOne( array("_id"  => new MongoId($id)));
		if(is_array($valores))foreach( $valores as $key => $value){
			$this->values[$key] = utf8_decode($value);
		}	
	}
    
	public function getByPk(){
		$values 	= func_get_args();
		$conn 		= $this->getDS();
		$tabla		= $this->getTable();
		$pk			= array();
		foreach( $this->pkFields as $index => $field){
			$pk[$field] = $values[$index];
		}
		if (count($pk)  ==  0) return ;
		$valores =  $conn->$tabla->findOne( $pk);
		if(is_array($valores))foreach( $valores as $key => $value){
			$this->values[$key] = utf8_decode($value);
		}	
	
	}

	public function insert() {
		$conn 		= $this->getDS();
		$tabla		= $this->getTable();
		$this->encodea();
		$valores=array();
		foreach($this->fields as $key => $value){
			if ($key != "_id" && !is_null($this->values[$key]))
				$valores[$value]=$this->values[$key];
		}
		$conn->$tabla->insert( $valores );
		
	}
	
	public function encodea(){
		foreach($this->values as $key => $value){
			if (!is_array($value))
				$this->values[$key] = utf8_encode($value);
		}
	}

	
	public function update() {
		$conn 		= $this->getDS();
		$tabla		= $this->getTable();
		$pk			= array();
		$this->encodea();
		foreach( $this->pkFields as $field){
			$pk[$field] = $this->values[$field];
		}
		$valores=array();
		foreach($this->fields as $key => $value){
			if ($key != "_id" && !is_null($this->values[$key]))
				$valores[$value]=$this->values[$key];
		}
		
		$conn->$tabla->update( $pk, array('$set' => $valores));
	}
	
	public function delete() {
		$conn 		= $this->getDS();
		$tabla		= $this->getTable();
		$pk			= array();
		foreach( $this->pkFields as $field){
			$pk[$field] = $this->values[$field];
		}
		$valores=array();
		foreach($this->values as $key => $value){
			if ($key != "_id" && !is_null($value))
				$valores[$key]="$value";
		}
		
		$conn->$tabla->remove( $pk, array("justOne" => true) );

	}
	

	public function save() {
		if ( $this->modified ) {
			if ( $this->new ) {
				$this->insert();
			} else {
				$this->update();
			}
			$this->modified = false;
			return true;
		} else {
			return false;
		}
	}


}


