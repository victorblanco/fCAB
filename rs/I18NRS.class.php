<?php


class I18NRS extends RecordSet{
	
	public function sql(  $tabla, $key, $value , $datasource) {
		$sql = "SELECT $key, $value FROM $tabla";
		$ds  = App::getDS($datasource);
		
		$rs	 = $ds->exec($sql);
		return array($ds, $rs);
	}
	
}