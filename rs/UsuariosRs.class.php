<?php



class UsuariosRS extends RecordSet{
	
	
	function sql(HashTable $filters = null){
		if(is_null($filters)) $filters = new HashTable();
		$where = null;
		$where 	.= " AND usuario ='".$filters->usuario."' AND password = md5('".$filters->password."')";
			
		
		return 	"SELECT * FROM  ".usuarios::getTable()."	WHERE 1	$where ".$this->makeOrder()." ".$this->makeLimit();
		
	}

}

?>
