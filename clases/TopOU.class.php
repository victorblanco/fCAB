<?php


class TopOU extends Output {

	protected $rs;
	protected $clases;
	
	public function __construct(){
		parent::__construct();
		
		#Factorys de objetos
		$this->rs = new Factory(RS);
		$this->clases = new Factory(CLASES);
	}

	public function getOutput(){
		try {
			
			$tpl = new Template("TopOU.tpl", tpl_dir, tpl_pre); 
			$ds = App::getDS();
			
			$h = new HashTable();
			$h->estado = 1;
			$order = new HashTable();
			$order->nombre = "ASC";
			$tpl->setVar("user", Session::get("descripcion"));
			
			return $tpl->parse();
			
		}catch ( Exception $e) { Debug::add($e); }
	}


}

?>
