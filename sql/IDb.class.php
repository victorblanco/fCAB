<?php

interface IDb {

	public function exec($sql);
	
	public function next($rs = null);
	
	public function close();
	
	public function connect();
	
	public function isConnect();
	
	public function free($rs = null);
	
	public function count($rs = null);
	
	public function id();
	
	public function beginTransaction();
	
	public function commit();
	
	public function rollback();
	
	public function affected();
	
	public function info();

}


?>