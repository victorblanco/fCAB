<?php

/**
* class AdminBotoneraRS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class AdminBotoneraRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		$sql	= $this->getSql($filters);
		$ds 	=  AdminBotonera::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	public function getPaginated($limit, $sql){
		$ds 		=  AdminBotonera::getDS();
		$paginator 	= $this->getPaginator($filters, $limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}
	
	protected function getPaginator($limit, $sql, $ds){
		$paginator = new Paginator($ds, $sql, $limit, App::request());
		return $paginator;
	}

	public function getAjaxPaginated($limit,$sql){
		$ds 		=  AdminBotonera::getDS();
		$paginator 	= $this->getAjaxPaginator($limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}

	protected function getAjaxPaginator($limit, $sql, $ds){
		$paginator = new AjaxAppenderPaginator($ds, $sql, $limit, App::request());
		return $paginator;
	}
	
	public function getSql($filters = null){
		$sql	= "SELECT * FROM " . AdminBotonera::getTable() . "  
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
			$i = new AdminBotoneraRS();
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
		
		if(!is_null($filters->id_botonera)) $where .= " AND id_botonera ='".$filters->id_botonera."' ";
		if(!is_null($filters->id_tabla)) $where .= " AND id_tabla ='".$filters->id_tabla."' ";
		if(!is_null($filters->icono)) $where .= " AND icono ='".$filters->icono."' ";
		if(!is_null($filters->url)) $where .= " AND url ='".$filters->url."' ";
		if(!is_null($filters->parametros)) $where .= " AND parametros ='".$filters->parametros."' ";
		if(!is_null($filters->caption)) $where .= " AND caption ='".$filters->caption."' ";
		
		
		return $where;
	}
	
}