<?php

/**
* class DebugRS
* 
* Clase que extiende de RecordSet y gestiona
* las querys y sus filtros		
*
*
*
*
*/

class DebugCabeceraRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		return "Select * from " . DebugCabeceraORM::getTable() . "  
				where phpsessionid ='".session_id()."' " .$this->makeWhere($filters)."  ".$this->makeOrder()." ".$this->makeLimit();
	}
	
	/**
	*	@Description: Singleton method
	*
	*/
	public static function getDefault(){
		static $i = null;
		
		if( is_null($i) ){
			$i = new DebugCabeceraRS();
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
		
		if(!is_null($filters->id)) $where .= " AND id ='".$filters->id."' ";
		
		
		return $where;
	}
	
}
