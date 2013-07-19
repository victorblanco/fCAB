<?php

/**
* class <!-- {clase} -->RS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class <!-- {clase} -->RS extends RecordSet implements IFactory{

	public function sql($filters = null){
		$sql	= $this->getSql($filters);
		$ds 	=  <!-- {clase} -->::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	public function getPaginated($limit, $sql){
		$ds 		=  <!-- {clase} -->::getDS();
		$paginator 	= $this->getPaginator($filters, $limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}
	
	protected function getPaginator($limit, $sql, $ds){
		$paginator = new Paginator($ds, $sql, $limit, App::request());
		return $paginator;
	}

	public function getAjaxPaginated($limit,$sql){
		$ds 		=  <!-- {clase} -->::getDS();
		$paginator 	= $this->getAjaxPaginator($limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}

	protected function getAjaxPaginator($limit, $sql, $ds){
		$paginator = new AjaxAppenderPaginator($ds, $sql, $limit, App::request());
		return $paginator;
	}
	
	public function getSql($filters = null){
		$sql	= "SELECT * FROM " . <!-- {clase} -->::getTable() . "  
				WHERE 1 " .$this->makeWhere($filters)."  ".$this->makeOrder()." ".$this->makeLimit();
		return $sql;
	}
	
	/**
	*	@Description: Singleton method
	*
	*/
	public static function getDefault(){
		static $i = null;
		
		if( is_null($i) ){
			$i = new <!-- {clase} -->RS();
		}
		return $i;
	}

	/**
	*	@Description: Crea los filtros
	*
	*/
	protected function makeWhere($filters){
	
		if (is_null($filters)) return null;
		
		$where = null;
		<!-- {rows} -->
		
		<!-- @ ROW @ -->
		if(!is_null($filters-><!-- {campo} -->)) $where .= " AND <!-- {campo} --> ='".$filters-><!-- {campo} -->."' ";<!-- @ ROW @ -->
		return $where;
	}
	
}