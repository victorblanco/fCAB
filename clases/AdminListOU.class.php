<?php


class AdminListOU extends Output{
	
	
	
	public function getOutput(){
		
		$this->checkSession();
		
		$tpl					= new Template("admin_list.tpl");
		list($ds, $rs) 			= AdminLogic::getCampos( "orden_lista" );
		$i18n					= FACTORIE::getDefault()->AdminTiposCamposI18N();
		
		$table 					= (AdminLogic::getTable()->nombreAdmin != "")?AdminLogic::getTable()->nombreAdmin:AdminLogic::getTable()->description;
		$col_models				= "";
		$col_names				= "";
		$formatter_functions 	= "";
		$primera				= true;
		$orm					= AdminLogic::getOrm();
		$pk_fields				= $orm->getPkFields();
		AdminBreadCrumbLogic::addBC($table,(AdminLogic::getInheritedParameters()!="")?3:1);
		while($row = $ds->next($rs)){
			//Si el orden es 0 no se muestra.
			if ($row->orden_lista == 0){
				continue;
			}
			if($primera){
				$index = $row->nombre;
				$primera = false;
			}
			
			$field_formatter 	= "";
			$formater_cases		= "";
			$sortable			= "true";
			if(strpos($row->extra,"RS")!==false && $row->id_tipo_campo == $i18n->SELECT){
				$sortable = "false";
				$class_rs = $row->extra;
				list($dsx,$rsx) = FACTORIE::getDefault()->$class_rs()->getSelector();
				while($rowx = $dsx->next($rsx)){
					$valoresx = $rowx->get();
					$tpl->setVarBlock("FIELD_FORMATTER_FUNCTION_CASE","key",($valoresx[0]));
					$tpl->setVarBlock("FIELD_FORMATTER_FUNCTION_CASE","value",($valoresx[1]));
					$formater_cases .= $tpl->parseBlock("FIELD_FORMATTER_FUNCTION_CASE");
				}
				$tpl->setVarBlock("FIELD_FORMATTER_FUNCTION","cases",$formater_cases);
				$tpl->setVarBlock("FIELD_FORMATTER_FUNCTION","name",$row->nombre);
				$formatter_functions .= $tpl->parseBlock("FIELD_FORMATTER_FUNCTION");
				
				$tpl->setVarBlock("FIELD_FORMATTER","name",$row->nombre);
				$field_formatter = $tpl->parseBlock("FIELD_FORMATTER");
				
			}
			
			
			
			$alineacion = ($row->alineacion=="")?"left":$row->alineacion;
			$descripcion = $row->descripcion != "" ? $row->descripcion : $row->nombre;
			$tpl->setVarBlock("COLUMN_MODEL","name",$descripcion);
			$tpl->setVarBlock("COLUMN_MODEL","index",$row->nombre);
			$tpl->setVarBlock("COLUMN_MODEL","width","10");
			$tpl->setVarBlock("COLUMN_MODEL","resizable","true");
			$tpl->setVarBlock("COLUMN_MODEL","sortable","$sortable");
			$tpl->setVarBlock("COLUMN_MODEL","align","$alineacion");
			$tpl->setVarBlock("COLUMN_MODEL","formatter",$field_formatter);
			$col_models .= $tpl->parseBlock("COLUMN_MODEL");
			
			$nombre_columna = ($row->descripcion=="")?$row->nombre:$row->descripcion;
			$tpl->setVarBlock("COLUMN_NAME","name",$nombre_columna);
			$col_names .= $tpl->parseBlock("COLUMN_NAME");
			
		}
	/*	var_dump(AdminLogic::getTable());
		die();
		*/
		$tpl->setVar("header", FACTORIE::getDefault()->AdminDetailOU()->getFields(null, "orden_busqueda",AdminLogic::getTable()->columnasLista));
		$tpl->setVar("columnas",AdminLogic::getTable()->columnasLista);
		$col_names = substr($col_names,1,strlen($col_names));
		$col_models = substr($col_models,1,strlen($col_models));
		
		//Calculo los parámetros que he de pasarle por ajax:
		
		$tpl->setVar("params",AdminLogic::getInheritedParameters());
		$tpl->setVar("idTable",App::request()->TABLE);
		$tpl->setVar("col_names",$col_names);
		$tpl->setVar("col_models",$col_models);
		$tpl->setVar("index",$index);
		$tpl->setVar("title","$table");
		$tpl->setVar("tabla","$table");
		$tpl->setVar("width","824");
		$tpl->setVar("height","385");
		$tpl->setVar("formatter_functions",$formatter_functions);
		
		return $tpl->parse();
	}
	
	
	public function getList(){
		$data 					= array();
		$i18n  					= FACTORIE::getDefault()->AdminTiposCamposI18N();
		$limit 					= (!App::request()->rows)?20:App::request()->rows;
		$orm					= AdminLogic::getOrm();
		list($ds, $rs)			= AdminLogic::getCampos("orden_lista");
		$fields					= $orm->getFields();
		
		
		$sql					= "SELECT * FROM ".$orm->getTable() . " WHERE 1 = 1 ";
		
		while($fila = $ds->next($rs)){
			$valor = App::request()->{$fila->nombre};
			
			if($valor != null){
				switch ($fila->id_tipo_campo){
					case $i18n->SELECT:
						$filters .= " AND ".$fields[$fila->nombre]." = '".utf8_decode($valor)."' ";
						break;
					case $i18n->DATE:
						$valor = Date::parse(App::request()->$key)->toSql();
						$filters .= " AND ".$fields[$fila->nombre]." = '".utf8_decode($valor)."' ";
						break;
					default:
						if( (in_array($fila->nombre,explode(",",App::request()->_params))) || (in_array($fila->nombre,explode(",",App::request()->_subgroup)))){
							$filters .= " AND ".$fields[$fila->nombre]." = '".utf8_decode($valor)."' ";
						}else{
							$filters .= " AND ".$fields[$fila->nombre]." like '%".utf8_decode($valor)."%' ";
						}
						break;
				}
			
				
			}
		}
		//var_dump($filters);
		Debug::add(__CLASS__.": Se comprueba _FILTER_ADMIN");
		
		if(((App::request()->_params == "" && App::request()->_subgroup == "") && Session::get("_FILTER_ADMIN") == "1")){
			Debug::add(__CLASS__.": Se comprueba _FILTER_ADMIN == 1 : ".Session::get("_current_filters"));
			$sql				.= Session::get("_current_filters");
			Session::unregister("_FILTER_ADMIN");
		}elseif($filters != ""){
			Debug::add(__CLASS__.": Se comprueba _FILTER_ADMIN != 1");
			$sql				.= $filters;
			Session::set("_current_filters",$filters);
		}
		
		
		
		
		$order->field			= $fields[App::request()->sidx];
		$order->sort			= App::request()->sord;
		
		$sql					.= "ORDER BY {$order->field} {$order->sort}";
		$ds						= $orm->getDS();
		$paginator				= new Paginator($ds, $sql, $limit, App::request());
		$rs						= $paginator->exec();
		
		$data['page']			= $paginator->getPage();
		$data['total']			= $paginator->getTotalPages();
		$data['records']		= $paginator->getTotalRecord();
		
		$orden					= $this->getOrderedFields();
		$pk_fields				= $orm->getPkFields();
		
		while($row=$ds->next($rs)){
			$orm->hydrate($row);
			$row_array = $row->get();
			$cells = array();
			foreach($orden as $valor){
				$cells[]=($orm->$valor);
			}
			$id_jqgrid = "";
			foreach($pk_fields as $field){
				$id_jqgrid .= $field.":".$orm->$field."|";
			}
			$rows[] = array(
				"id" 	=> $id_jqgrid
				,"cell"	=> $cells
				);				
		}
		$data["rows"]=$rows;
		
		return $data;
		
	}
	
	
	protected function getOrderedFields(){
		list($ds, $rs) 	= AdminLogic::getCampos( "orden_lista" );
		
		$table 			= AdminLogic::getTable()->description;
		$orden 			= array();
		
		while($row = $ds->next($rs)){
			$orden[]=$row->nombre;
		}
		
		return $orden;
	}
	
	protected function checkSession(){
		if(App::request()->_filter_adm == 1){
			Session::set('_FILTER_ADMIN',1);
		}else{
			Session::set('_FILTER_ADMIN',0);
			Session::unregister("_current_filters");
		}
	}
}
