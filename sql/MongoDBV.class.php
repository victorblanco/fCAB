<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class MongoDBV extends DB{


	public function __construct($dbName,$host,$user,$pass){
	
		parent::__construct();
		$this->host   = $host;
		$this->user   = $user;
		$this->pass   = $pass;
		$this->dbName = $dbName;
	}
   
   	public function __destruct(){
		$this->free();
		unset($this);
	}
	
	/**
	*
	*/

	public function connect(){
		$this->con  = new Mongo("mongodb://{$this->host}");
		if(!$this->con){
			throw new DBException("!! - MongoDB: -> No se puede conectar con ".$this->host);
		}

		$this->db = $this->con->{$this->dbName}; 
		if(!$this->db) { 
			throw new DBException("No se ha seleccionado la DB  '".$this->dbName."' " );
			//TODO mysql_error($this->con);
		}
		
		$this->abierta = true;
		Debug::add("MONGODB: Conectando con DB: " .$this->dbName );
		return $this->con;
	}

	public function affected(){
		//return @mysql_affected_rows();
	}
	
	public function info(){
		//return @mysql_info();
	}
		
	public function getHeaders(){
		/*$columns = $this->getNumberColumns();
		$headers = array();
		for ($i=0; $i < $columns ;$i++){
			$headers[] = mysql_field_name($this->rs, $i);
		}
		return $headers;
		*/
	}
	
	public function __get( $var ){
		return $this->db->$var;
	}
	
	public function getNumberColumns(){
		//return mysql_num_fields($this->rs);
	}
	/**
	*
	*/
	public function setCollection( $tabla ){
		$this->collection = $tabla;
		return $this;
	}
	
	public function exec($filters = null, HashTable $limit = null, HashTable $orden = null){
		$tabla		= $this->collection;
		$filters = $filters->toArray();
		$cursor 	= $this->db->$tabla->find($filters);
		
		
		if ($limit != null){
			$cursor->limit($limit->superior)
					->skip($limit->inferior);
		}
		if ($orden != null){
			$cursor->sort( $orden->toArray() );
		}
		
		$this->rs = $cursor;
		
		Debug::addQuery(__CLASS__." Collection: $tabla - Filtros ".$this->getStringFilters($filters) , 0);
		Debug::addBackTrace();
	}
	
	protected function getStringFilters( $filters ){
		$tmp = "";
		foreach( $filters as $key => $value){
			$tmp .= " $key => $value | ";
		}
		
		return $tmp;
	}

	/**
	*
	*/
	public function next($rs = null){
		$dr = new DataSetRow();
		if(is_null($rs)){
			$ret = $dr->set(@$this->rs->getNext(), true);
			if (!$ret)$this->free($this->rs);
			return $ret;
		}else{
			$ret = $dr->set(@$this->rs->getNext(),true);
			if (!$ret)$this->free($rs);
			return $ret;
		}
	}

	public function close(){
		/*Debug::add("MYSQL : Cerrando coneccion (MySql)");
		$this->abierta=false;
		@mysql_close($this->con);*/
	}
	
	/**
	*
	*/
	public function isConnect(){
		//return $this->abierta;
	}
	
	/**
	*
	*/
	public function free($rs = null){
		unset($rs);
	//	Debug::add("MYSQL: Liberando memoria (MySql)");
	//	if(is_null($rs)) return @mysql_free_result($this->rs);
	//	else return @mysql_free_result($rs);
	}
	
	/**
	*
	*/
	public function count($rs = null){
	//	if(is_null($rs)) return @mysql_num_rows($this->rs);
	//	else return @mysql_num_rows($rs);
	}
	
	public function id(){
		//return @mysql_insert_id($this->con);
	}
	
	/**
	*
	*/
	public function beginTransaction(){
	//	$this->exec("START TRANSACTION");
	}
	
	/**
	*
	*/
	public function commit(){
		//$this->exec("COMMIT");
	}
	
	/**
	*
	*/
	public function rollback(){
		$this->exec("ROLLBACK");
	}

	public function __toString(){
		return get_class($this). " -> HOST: $this->host, USSER: $this->user, PASSWORD: $this->pass";
	}
}
