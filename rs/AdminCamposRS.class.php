<?php

/**
* class AdminCamposRS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class AdminCamposRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		$sql	= $this->getSql($filters);
		$ds 	=  AdminCampos::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	public function getPaginated($limit, $sql){
		$ds 		=  AdminCampos::getDS();
		$paginator 	= $this->getPaginator($filters, $limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}
	
	public function getSelector(){
		
					
		$sql	= "SELECT nombre as id, nombre FROM " . AdminCampos::getTable() ."  
				WHERE 1 " .$this->makeWhere(App::request());
		$ds 	=  AdminCampos::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	protected function getPaginator($limit, $sql, $ds){
		$paginator = new Paginator($ds, $sql, $limit, App::request());
		return $paginator;
	}

	public function getAjaxPaginated($limit,$sql){
		$ds 		=  AdminCampos::getDS();
		$paginator 	= $this->getAjaxPaginator($limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}

	protected function getAjaxPaginator($limit, $sql, $ds){
		$paginator = new AjaxAppenderPaginator($ds, $sql, $limit, App::request());
		return $paginator;
	}
	
	public function getSql($filters = null){
		$sql	= "SELECT * FROM " . AdminCampos::getTable() . "  
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
			$i = new AdminCamposRS();
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
		
		if(!is_null($filters->id_campo)) $where .= " AND id_campo ='".$filters->id_campo."' ";
		if(!is_null($filters->nombre)) $where .= " AND nombre ='".$filters->nombre."' ";
		if(!is_null($filters->id_tabla)) $where .= " AND id_tabla ='".$filters->id_tabla."' ";
		if(!is_null($filters->idTabla)) $where .= " AND id_tabla ='".$filters->idTabla."' ";
		if(!is_null($filters->id_tipo_campo)) $where .= " AND id_tipo_campo ='".$filters->id_tipo_campo."' ";
		if(!is_null($filters->extra)) $where .= " AND extra ='".$filters->extra."' ";
		if(!is_null($filters->action)) $where .= " AND action ='".$filters->action."' ";
		if(!is_null($filters->js)) $where .= " AND js ='".$filters->js."' ";
		if($filters->orden_lista) $where .= " AND orden_lista >0";
		if($filters->orden_detalle) $where .= " AND orden_detalle >0 ";
		if($filters->orden_busqueda) $where .= " AND orden_busqueda >0 ";
		if(!is_null($filters->clase_validador)) $where .= " AND clase_validador ='".$filters->clase_validador."' ";
		if(!is_null($filters->alieneacion)) $where .= " AND alieneacion ='".$filters->alieneacion."' ";
		
		
		return $where;
	}
	
}