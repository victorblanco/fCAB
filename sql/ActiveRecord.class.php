<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class ActiveRecord  extends Object implements Iterator{

	protected $modified = false;
	
	protected $new = true;
	protected $lastId;
	
	protected $filters = array();
	protected $valid_operators = array("=", ">=", "<=", "like", "<>", ">", "<");

	public function isNew(){
		return $this->new;
	}

    public function rewind() {
        reset( $this->values );
    }
   
    public function current() {
        return current( $this->values );
    }
   
    public function key() {
        return key( $this->values );
    }
   
    public function valid() {
        return key( $this->values );
    }
   
    public function next() {
        next( $this->values );
    }
   
    public function count() {
        return count($this->values);
    }
    
    public function getPkFields(){
    	return $this->pkFields;
    }
    
    public function getFields(){
    	return $this->fields;
    }
    
    public function addFilters( $field , $value, $operator = "=", $like = false){
    	if(array_key_exists($field, $this->fields)){
    		if(in_array($operator, $this->valid_operators)){
    			$this->filters[] = array($field, $value, $operator, $like);
    			return $this;
    		}else{
    			throw new DBException("Operador $operator no valido." ); 
    		}
    	}else{
    		throw new DBException("No existe el campo $field en la tabla " . $this->getTable()); 
    	}
    }
	public function getByFilters( $clean = false){
		
		$conn = $this->getDS();
		
		$values = func_get_args();
		if (count( $this->filters ) ==  0) {
			throw new Exception('Wrong number of filters fields. Use addFilters');
		}
		
		$temp = null;
		foreach($this->filters as $filter){
			list($field, $value, $operator, $like) = $filter;
			$l 			= $like ? "%" : "";
			$operator	= $like ? "like" : $operator;
			$temp .= " and $field $operator '$l" . $value. "$l'";
		}
		
	 	$sql 			= sprintf( 'select * from %s where 1 %s', $this->getTable(), $temp );
	 	$this->filters 	= $clean ? array() : $this->filters; 
		try {
			$ex = @$conn->exec( $sql );
			if(!$ex)
				throw new Exception("ERROR:  al ejecutar la query: $sql");
				
			if ( $rs = $conn->next() ) {
				$class = $this->getClass();
				$ar = new $class();
				$ar->hydrate( $rs );
				return $ar;
			} else {
				return null;
			}
		}catch (Exception $e){
			throw $e;
		}
	
	}
    
	public function getByPk(){
		
		$conn = $this->getDS();
		
		$values = func_get_args();
		if ( sizeof( $this->pkFields ) != sizeof( $values ) ) {
			throw new Exception( sprintf( 'Wrong number of PK fields. Expected %d, Received %d', sizeof( $this->pkFields ), $values ) );
		}
		
		$temp = null;
		foreach($this->pkFields as $index => $pk){
			$temp .= " and " . $this->fields[$pk] . " = '" . $values[$index]. "'";
		}
		
	 	$sql = sprintf( 'select * from %s where 1 %s', $this->getTable(), $temp );
		try {
			$ex = @$conn->exec( $sql );
			if(!$ex)
				throw new Exception("ERROR:  al ejecutar la query: $sql");
				
			if ( $rs = $conn->next() ) {
				$class = $this->getClass();
				$ar = new $class();
				$ar->hydrate( $rs );
				return $ar;
			} else {
				return null;
			}
		}catch (Exception $e){
			throw $e;
		}
	
	}
	
	
	public function __get( $field ) {
		if ( array_key_exists( $field, $this->values ) ) {
			return $this->values[$field];
		} else {
			throw new Exception( sprintf( 'ERROR: Invalid field: "%s"', $field ) );
		}
	}
	
	public function __set($field,$value){
		if ( array_key_exists( $field, $this->values ) ) {
			if ( ( $this->values[$field] === null && $value !== null ) || $value != $this->values[$field] ) {
				$this->values[$field] = $value;
				$this->modified = true;
			}
		}
	}
	

	private function loadInsertID( $conn ){
		$id = $conn->id();
		foreach($this->pkFields as $index => $pk){
			if ($this->values[$pk] == ''){
				$this->values[$pk] = $id;
			}
			
		}

	}
	public function setFunction($field, FunctionsDb $function){
		$this->values[$field] = $function;
	}
	protected function clear() {
		foreach( $this->values as $field => $value ) {
			$this->values[$field] = null;
		}
		$this->new = true;
		$this->modified = false;
	}
	
	public function magicQuotes( $data ){
		if (!get_magic_quotes_gpc()){
			if (is_array($data))
				return array_map('fixMagicQuotes', $data);
			else
				return addslashes($data);
		}
		else return $data;
	}
	
	public function insert() {
	
		$conn = $this->getDS();
		
		$campos 	= array();
		$valores 	= array();
		
		foreach($this->fields as $orName => $dbName){
			if ($this->values[$orName] instanceof FunctionsDb){
				$function	= $this->values[$orName];
				$valores[]  =  $function->getFunction();
			}else{
				$valores[] 	= "'".$this->magicQuotes ($this->values[$orName])."'";
			}
			$campos[] 	= $dbName;
		}
		$sql = sprintf( 'insert into %s ( %s ) values ( %s )', 
						$this->getTable(), 
						implode( ', ', $campos ), 
						implode( ', ', $valores) );
		
		try {
			$ex = @$conn->exec( $sql );
			$this->loadInsertID( $conn );
			$this->new = false;
			$this->modified = false;
			
		} catch ( Exception $e ) {
			throw $e ;
		}
	}

	
	
	public function update() {
	
		$conn = $this->getDS();
		
		$where 	= array();
		$valores 	= array();
		
		foreach($this->fields as $orName => $dbName){
			if($this->values[$orName] === null || $this->values[$orName] === false) continue;
			
			if ($this->values[$orName] instanceof FunctionsDb){
				$function	= $this->values[$orName];
				$valores[]  = "$dbName = ".$function->getFunction();
			}else{
				$valores[] 	= "$dbName = '".$this->magicQuotes ($this->values[$orName])."'";
			}
		}
		
		foreach($this->pkFields as $orName){
			$campo = $this->fields[$orName];
			$where[] = " $campo = '".$this->values[$orName]."' ";
		}
		
		$sql = sprintf( 'update %s set %s where %s', 
							$this->getTable(), 
							implode( ', ', $valores ), 
							implode( ' and ', $where ) );
							
		
		try {
			return $ex = $conn->exec($sql);
			$this->modified = false;
		} catch ( Exception $e ) {
			throw new Exception("ERROR: " . $e->getMessage() );
		}

	}
	
	public function delete() {
	
		$conn = $this->getDS();
		
		foreach($this->pkFields as $orName){
			$campo = $this->fields[$orName];
			$where[] = " $campo = '".$this->values[$orName]."' ";
		}
		
		$sql = sprintf( 'delete from %s where %s', 
							$this->getTable(), 
							implode( ' and ', $where ) );
		try {
			$ex = $conn->exec($sql);
			if($ex){
				$this->clear();
				return true;
			}
			return false;
		} catch ( Exception $e ) {
			throw new Exception("ERROR: " . $e->getMessage() );
		}

	}
	
	public function hydrate($rs ) {
		if ( true) {
			foreach( $this->fields as $field => $dbField ) {
				$this->values[$field] = $rs->$dbField;
			}
		} else {
			foreach( self::$fields as $field => $dbField ) {
				$this->values[$field] = $rs->$dbField;
			}
		}
		$this->new = false;
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


?>
