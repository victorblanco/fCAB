<?php



class MenuRS extends RecordSet{
	
	
	function sql(HashTable $filters = null){
		if(is_null($filters)) $filters = new HashTable();
		$where = null;
		
		if(!is_null($filters->codNivel))	
			$where 	.= " AND codNivel ='".$filters->codNivel."'";
		
		return 	"SELECT * FROM  asLAB_menu WHERE 1 $where ".$this->makeOrder()." ".$this->makeLimit();
		
	}

}

?>
