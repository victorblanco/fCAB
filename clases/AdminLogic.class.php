<?php


class AdminLogic extends Object{
	static $table;
	static $campos;
	static $orm;
	static $rs;
	static $new;
	
	static function verifica(){
		if (is_null(App::request()->TABLE)){
			throw new GenException("Imposible Calcular la tabla");
		}
		
		
	}
	static function init(){
		self::verifica();
		
		self::$table = FACTORIE::getDefault()->AdminTablas()->getByPk(App::request()->TABLE);
		if (self::$table == null){
			throw new GenException("Estructura de tabla no definida");
		}else{
			self::setORM();
			if (!self::$orm->isNew()){
				Debug::add("Registro ya creado");
				self::$new = false;
			}else{
				Debug::add("Registro nuevo");
				self::$new = true;
			}
		}
	}
	
	static function isNew(){
		return self::$new;
	}
	
	static function getOrm(){
		if(!is_null(self::$orm)){
			return self::$orm;
		}else{
			$class	= self::$table->description;
			return FACTORIE::getDefault()->$class();
		}
	}
	
	static function getRs(){
		if(!is_null(self::$rs)){
			return self::$rs;
		}else{
			$class	= self::$table->description."RS";
			return FACTORIE::getDefault()->$class();
		}
	}
	
	static function getTable(){
		return self::$table;
	}
	
	
	static function getCampos( $campo_orden= "orden_detalle" ){
		$filters 				= new HashTable();
		$filters->id_tabla		=	 (string)self::$table->idTabla;
		$filters->$campo_orden	= true;
		
		$orden					= new HashTable();
		$orden->$campo_orden	= "ASC";
		
		return FACTORIE::getDefault()->AdminCamposRS()->setOrder($orden)->sql( $filters );
	}
	
	static function setORM(){
		$class	= self::$table->description;
		
		
		$orm	= FACTORIE::getDefault()->$class();
		
		$sql 	= "SELECT * from ".$orm->getTable()." WHERE 1 ";
		$pks	= $orm->getPkFields();
		$fields	= $orm->getFields();
		$where	= "";
		
		foreach( $pks as $key => $pk){
			$where .= " and ".$fields[$pk]." = '".mysql_real_escape_string(App::request()->$pk)."' ";
		}
		
		$sql .= $where;
		
		$ds = $orm->getDS();
		$rs	= $ds->exec( $sql );
		if($fila = $ds->next($rs)){
			$orm->hydrate( $fila );
		}
		self::$orm = $orm;
	}
	
	static function getInheritedParameters($parametros = ""){
		$params = "";
		if(App::request()->_subgroup!=""){
			$explode_params = explode(",",App::request()->_subgroup);
			if(is_array($explode_params)){
				foreach($explode_params as $param){
					$params .= "&{$param}=".App::request()->$param;
				}
				$params.="&_subgroup=".App::request()->_subgroup;
			}
		}
		
		if(App::request()->_params != ""){
			$explode_params = explode(",",App::request()->_params);
			if(is_array($explode_params)){
				foreach($explode_params as $param){
					$params .= "&{$param}=".App::request()->$param;
				}
				$params.="&_params=".App::request()->_params;
			}
		}elseif($parametros != ""){
			$params = "";
			$explode_params = explode(",",$parametros);
			if(is_array($explode_params)){
				foreach($explode_params as $param){				
					$params .= "&{$param}=".self::$orm->$param;
				}
				$params.="&_params=".$parametros;
			}
		}
		return $params;
		
	}
	
}
