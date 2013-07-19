<?php

/**
* class AdminTablasRS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class AdminTablasRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		$sql	= $this->getSql($filters);
		$ds 	=  AdminTablas::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	public function getSelector($filters = null){
		$sql	= "select id_tabla, description from " . AdminTablas::getTable() ;
		$ds 	=  AdminTablas::getDS();
		$result = $ds->exec($sql);
		return array($ds, $result);
	}
	
	public function getPaginated($limit, $sql){
		$ds 		=  AdminTablas::getDS();
		$paginator 	= $this->getPaginator($filters, $limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}
	
	protected function getPaginator($limit, $sql, $ds){
		$paginator = new Paginator($ds, $sql, $limit, App::request());
		return $paginator;
	}

	public function getAjaxPaginated($limit,$sql){
		$ds 		=  AdminTablas::getDS();
		$paginator 	= $this->getAjaxPaginator($limit, $sql, $ds);
		$rs 		= $paginator->exec();

		return array($ds, $rs, $paginator);
	}

	protected function getAjaxPaginator($limit, $sql, $ds){
		$paginator = new AjaxAppenderPaginator($ds, $sql, $limit, App::request());
		return $paginator;
	}
	
	public function getSql($filters = null){
		$sql	= "SELECT * FROM " . AdminTablas::getTable() . "  
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
			$i = new AdminTablasRS();
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
		
		if(!is_null($filters->id_tabla)) $where .= " AND id_tabla ='".$filters->id_tabla."' ";
		if(!is_null($filters->description)) $where .= " AND description ='".$filters->description."' ";
		if(!is_null($filters->nombre_admin)) $where .= " AND nombre_admin ='".$filters->nombre_admin."' ";
		if(!is_null($filters->columnas)) $where .= " AND columnas ='".$filters->columnas."' ";
		if(!is_null($filters->js)) $where .= " AND js ='".$filters->js."' ";
		if(!is_null($filters->p_modify)) $where .= " AND p_modify ='".$filters->p_modify."' ";
		if(!is_null($filters->p_view)) $where .= " AND p_view ='".$filters->p_view."' ";
		if(!is_null($filters->p_delete)) $where .= " AND p_delete ='".$filters->p_delete."' ";
		if(!is_null($filters->p_add)) $where .= " AND p_add ='".$filters->p_add."' ";
		
		/**
		 * Filtro personalizado para obtener las tablas administrables por cliente
		 */
		if(is_array($filters->client_tables) && count($filters->client_tables) > 0){
			Debug::add(__CLASS__.": Se calculan filtros de tablas por cliente");
			$client_tables = "";
			foreach($filters->client_tables as $tabla){
				$client_tables .= "'$tabla',";
			}
			$client_tables = substr($client_tables,0,-1);
			$where .= " AND id_tabla IN ($client_tables) ";
		} 
		
		
		return $where;
	}
	
}