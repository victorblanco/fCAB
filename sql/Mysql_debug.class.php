<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class Mysql_debug extends DB implements IDb{


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
		$this->con  = @mysql_connect($this->host,$this->user,$this->pass, true);
		
		if(!$this->con){
			throw new DBException("ERROR: MYSQL DEBUG -> No se puede conectar con ".$this->host);
		}

		$this->db = mysql_select_db($this->dbName,$this->con); 
		if(!$this->db) { 
			throw new DBException("No se ha seleccionado la DB  '".$this->dbName."' " . mysql_error($this->con));
		}
		
		$this->abierta = true;
		return $this->con;
	}

	public function affected(){
		return @mysql_affected_rows();
	}
	
	public function info(){
		return @mysql_info();
	}
		
	public function getHeaders(){
		$columns = $this->getNumberColumns();
		$headers = array();
		for ($i=0; $i < $columns ;$i++){
			$headers[] = mysql_field_name($this->rs, $i);
		}
		return $headers;
		
	}
	
	public function getNumberColumns(){
		return mysql_num_fields($this->rs);
	}
	/**
	*
	*/
	public function exec($sql){
		$time1 = microtime();
		$this->con = $this->Connect();
		$this->rs = @mysql_query($sql,$this->con);
		
		if(!$this->rs || mysql_error($this->con)){ 
			throw new DBException(mysql_error($this->con). "\n $sql" );

		}
		$time2 = microtime();
		return $this->rs;
	}

	/**
	*
	*/
	public function next($rs = null){
		$dr = new DataSetRow();
		if(is_null($rs)){
			$ret = $dr->set(@mysql_fetch_array($this->rs, MYSQL_BOTH));
			if (!$ret)$this->free($this->rs);
			return $ret;
		}else{
			$ret = $dr->set(@mysql_fetch_array($rs, MYSQL_BOTH));
			if (!$ret)$this->free($rs);
			return $ret;
		}
	}

	public function close(){
		$this->abierta=false;
		@mysql_close($this->con);
	}
	
	/**
	*
	*/
	public function isConnect(){
		return $this->abierta;
	}
	
	/**
	*
	*/
	public function free($rs = null){
		if(is_null($rs)) return @mysql_free_result($this->rs);
		else return @mysql_free_result($rs);
	}
	
	/**
	*
	*/
	public function count($rs = null){
		if(is_null($rs)) return @mysql_num_rows($this->rs);
		else return @mysql_num_rows($rs);
	}
	
	public function id(){
		return @mysql_insert_id($this->con);
	}
	
	/**
	*
	*/
	public function beginTransaction(){
		$this->exec("START TRANSACTION");
	}
	
	/**
	*
	*/
	public function commit(){
		$this->exec("COMMIT");
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

