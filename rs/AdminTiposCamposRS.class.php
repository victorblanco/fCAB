<?php

/**
* class AdminTiposCamposRS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class AdminTiposCamposRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		$sql	= $this->getSql($filters);
		$ds 	=  AdminTiposCampos::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	public function getSelector(){
		$sql	= "SELECT id_tipo_campo, description FROM " . AdminTiposCampos::getTable() ;
		$ds 	=  AdminTiposCampos::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	public function getPaginated($limit, $sql){
		$ds 		=  AdminTiposCampos::getDS();
		$paginator 	= $this->getPaginator($filters, $limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}
	
	protected function getPaginator($limit, $sql, $ds){
		$paginator = new Paginator($ds, $sql, $limit, App::request());
		return $paginator;
	}

	public function getAjaxPaginated($limit,$sql){
		$ds 		=  AdminTiposCampos::getDS();
		$paginator 	= $this->getAjaxPaginator($limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}

	protected function getAjaxPaginator($limit, $sql, $ds){
		$paginator = new AjaxAppenderPaginator($ds, $sql, $limit, App::request());
		return $paginator;
	}
	
	public function getSql($filters = null){
		$sql	= "SELECT * FROM " . AdminTiposCampos::getTable() . "  
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
			$i = new AdminTiposCamposRS();
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
		
		if(!is_null($filters->id_tipo_campo)) $where .= " AND id_tipo_campo ='".$filters->id_tipo_campo."' ";
		if(!is_null($filters->description)) $where .= " AND description ='".$filters->description."' ";
		if(!is_null($filters->extra)) $where .= " AND extra ='".$filters->extra."' ";
		
		
		return $where;
	}
	
}