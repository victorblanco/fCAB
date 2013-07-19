<?php


class AdminListTablesOU extends Output{
	
	
	function getOutput(){
		list($ds, $rs) 	= FACTORIE::getDefault()->AdminTablasRS()->sql();
		$tpl			= new Template("admin_list_tables.tpl");
		$tmp			= "";
		while($fila = $ds->next($rs)){
			
			$descriptor = ($fila->nombre_admin != "")?$fila->nombre_admin:$fila->description;
			$tpl->setVarBlock("TABLA", $fila->get())
				->setVarBlock("TABLA","descriptor",$descriptor);
			
			
			
			$tmp	.= $tpl->parseBlock("TABLA");
		}
		
		return $tpl->setVar("tablas", $tmp)->parse();
	}
	
}