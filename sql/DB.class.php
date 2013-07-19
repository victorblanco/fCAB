<?php 


abstract  class DB  extends Object{

	protected $db     	= null;
	
	protected $con   	= null;
	
	protected $rs     	= null;
	
	protected $host   	= null;
	
	protected $user   	= null;
	
	protected $pass   	= null;
	
	protected $dbName 	= null;
	
	protected $abierta	= false;
	
	public function getArray( $rs ){
		$data	= array();
		$i 		= 0;
		while($row = $this->next( $rs )){
			$fila = $row->get();
			
			foreach( $fila as $key => $value){
				$data[$i][$key] = $value;
			}
			$i ++;
		}
		return $data;
		
	} 

}

