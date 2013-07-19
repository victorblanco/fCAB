<?php
/**
*	@Description: Crea y gestiona el menú left
*
*
*
*	@Author: Víctor Blanco 
*
*
*
*/



class MenuLeftOU extends Output{
	
	protected $tpl 	= null;
	protected $menu = null;
	protected $rs;
	protected $clases;
	
	function __construct() {
		parent::__construct();
		$this->rs = new Factory(RS);
		$this->clases = new Factory(CLASES);
	}
	
	
	function getOutput(){ 
		
		try {
			$this->tpl = new Template("MenuLeftOU.tpl", tpl_dir, tpl_pre); 
			
			$this->getMenu();
			$this->tpl->setVar("menu", $this->menu );

			return $this->tpl->parse();
			
		}catch(Exception $e){
			Debug::add($e);
		}
	
	}
	
	
	protected function getMenu($nivel = 0,$dependencia = "foldersTree",$cont = 1){
		
		$ds = App::getDS();
		$h = new HashTable();
		$h->codNivel = $nivel;
		
		$order = new HashTable();
		$order->ordenNivel = "ASC";
		
		try {
			$ex = $ds->exec( $this->rs->MenuRS->setOrder($order)->sql($h) );
			while ($row = $ds->next($ex)){

				$icoa = ($row->icoa != '') ? $row->icoa : ( ($row->nivelDestino == 0) ? 'ftv2doc.gif' : 'ftv2folderopen.gif' );
				$icoc = ($row->icoc != '') ? $row->icoc : 'ftv2folderclosed.gif';
				$permisos = Session::get('perfil') & $row->permisos;
				//var_dump(Session::get('perfil'))
				//echo "$permisos = Session::get('perfil') & $row->permisos;";
				if ($row->nivelDestino != 0 && $permisos){
				
					$this->tpl->setVarBlock("CONPERMISO","dependencia",$dependencia);
					$this->tpl->setVarBlock("CONPERMISO","descripcion",$row->descripcion);
					$this->tpl->setVarBlock("CONPERMISO","cont",$cont);
					$this->tpl->setVarBlock("CONPERMISO","icoa",$icoa);
					$this->tpl->setVarBlock("CONPERMISO","icoc",$icoc);
					$this->tpl->setVarBlock("CONPERMISO","nivelDestino",$row->nivelDestino);
					
					$this->menu .= $this->tpl->parseBlock("CONPERMISO",1);
					$this->getMenu($row->nivelDestino,"aux$cont",($cont + 1));
					
				}elseif ($permisos){ 
				
					$this->tpl->setVarBlock("SINPERMISO","dependencia",$dependencia);
					$this->tpl->setVarBlock("SINPERMISO","descripcion",$row->descripcion);
					$this->tpl->setVarBlock("SINPERMISO","pagDestino",$row->pagDestino);
					$this->tpl->setVarBlock("SINPERMISO","icoc",$icoa);
					
					
					$this->menu .= $this->tpl->parseBlock("SINPERMISO",1);
				}	
			}
		 }catch ( Exception $e) { Debug::add($e); }
	}
}

?>