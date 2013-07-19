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

class DebugRS extends RecordSet implements IFactory{

	public function sql($filters = null){
		return "Select * from " . DebugORM::getTable() . "  
				where 1 " .$this->makeWhere($filters)."  ".$this->makeOrder()." ".$this->makeLimit();
	}
	
	/**
	*	@Description: Singleton method
	*
	*/
	public static function getDefault(){
		static $i = null;
		
		if( is_null($i) ){
			$i = new DebugRS();
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
		if(!is_null($filters->txt)) $where .= " AND txt ='".$filters->txt."' ";
		if(!is_null($filters->tipo)) $where .= " AND tipo ='".$filters->tipo."' ";
		if(!is_null($filters->backtrace)) $where .= " AND backtrace ='".$filters->backtrace."' ";
		if(!is_null($filters->app)) $where .= " AND app ='".$filters->app."' ";
		
		
		return $where;
	}
	
}