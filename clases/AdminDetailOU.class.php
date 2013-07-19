<?php


class AdminDetailOU extends Output{
	
	protected $titleBC = "";
	
	function getOutput(){
	
		$tpl 			= new Template("admin_detail.tpl");
		$tmp2 			= $this->getFields($tpl);
		
			
		$tpl->setVar("params", AdminLogic::getInheritedParameters());
		$tpl->setVar("TABLE", AdminLogic::getTable()->idTabla);
		$tpl->setVar("description", AdminLogic::getTable()->description);
		$tpl->setVar("url_pk", $this->getUrlPk());
		$tpl->setVar("ncolumnas", (int)AdminLogic::getTable()->columnas );
		$tpl->setVar("columnas", $tmp2);
		
		
		AdminBreadCrumbLogic::addBC(($this->titleBC == "")?$tpl->parseBlock("NUEVO_ELEMENTO")." ".((AdminLogic::getTable()->nombreAdmin != "")?AdminLogic::getTable()->nombreAdmin:AdminLogic::getTable()->description)."":$this->titleBC,(AdminLogic::getInheritedParameters()!="")?4:2);
		
		if(!AdminLogic::isNew()){
			$botonera 		= $this->getBotonera($tpl);
			
			$tpl->setVar("botonera", $boton_nuevo.$botonera);
			
			$boton_nuevo	= $tpl->setVarBlock("BOTON_NUEVO","params", AdminLogic::getInheritedParameters())
								->setVarBlock("BOTON_NUEVO","TABLE", AdminLogic::getTable()->idTabla)
								->parseBlock("BOTON_NUEVO");
			
			$tpl->setVar("boton_nuevo", $boton_nuevo);
			
			$boton_eliminar	= $tpl->setVarBlock("BOTON_ELIMINAR","params", AdminLogic::getInheritedParameters())
								->setVarBlock("BOTON_ELIMINAR","TABLE", AdminLogic::getTable()->idTabla)
								->setVarBlock("BOTON_ELIMINAR","url_pk", $this->getUrlPk())
								->parseBlock("BOTON_ELIMINAR");
								
			$tpl->setVar("boton_eliminar", $boton_eliminar);
			
			$boton_eliminar_msie	= $tpl->setVarBlock("BOTON_ELIMINAR_MSIE","params", AdminLogic::getInheritedParameters())
								->setVarBlock("BOTON_ELIMINAR_MSIE","TABLE", AdminLogic::getTable()->idTabla)
								->setVarBlock("BOTON_ELIMINAR_MSIE","url_pk", $this->getUrlPk())
								->parseBlock("BOTON_ELIMINAR_MSIE");
								
			$tpl->setVar("boton_eliminar_msie", $boton_eliminar_msie);
			
			$funcion_eliminar = $tpl->setVarBlock("FUNCION_ELIMINAR","descriptor",$this->titleBC)->parseBlock("FUNCION_ELIMINAR");
			$tpl->setVar("funcion_eliminar", $funcion_eliminar);
			
			$formulario_ajax = $tpl->parseBlock("FORMULARIO_AJAX");
			$tpl->setVar("formulario_ajax", $formulario_ajax);
			
		}
		$tpl->setVar("botonera", $botonera);
		
		return $tpl->parse();
		
	}
	
	
	protected function getUrlPk(){
		$orm 		= AdminLogic::getOrm();
		$pkFields	= $orm->getPkFields();
		$url		= "";
		foreach($pkFields as $key){
			$url .= "&$key=".$orm->$key;
		}
		
		return $url;
	}
	
	public function getFields($tpl =null, $orden = "orden_detalle",$columnas=null){
		if ($tpl == null )$tpl 			= new Template("admin_detail.tpl");
		list($ds, $rs) 	= AdminLogic::getCampos( $orden );
		$descriptor 	= AdminLogic::getTable()->campoDescriptor;
		$orm			= AdminLogic::getORM();
		$pks			= $orm->getPkFields();
		if( $descriptor != ""){
			$this->titleBC = $orm->$descriptor;
		}else{
			foreach($pks as $pk){
				$this->titleBC .= $orm->$pk."-";
			}
			$this->titleBC = substr($this->titleBC,0,-1);
		}
		$tmp			= "";
		$tmp2			= "";	
		$total 			= $ds->count( $rs );
		$columnas 		= ($columnas != 0)?$columnas:(int)AdminLogic::getTable()->columnas; 
		$cxc			= round($total / $columnas);
		$j				= 0;
		
		while($row = $ds->next($rs)){
			$nombreCampo	= $row->nombre;
			$j++;
			//Si el orden es 0 no se muestra.
			$descripcion = $row->descripcion != "" ? $row->descripcion : $row->nombre;
			$tpl->setVarBlock("CAMPO", "etiqueda", $descripcion);
			$i  		= FACTORIE::getDefault()->AdminTiposCamposI18N();
			$bloque 	= $i->getKeyByValue( $row->id_tipo_campo );
			$campo		= $row->nombre;
			if(!AdminLogic::isNew()){
				$value =  $orm->$campo;
				$tpl->setVarBlock($bloque, "value", $value);
				
			}else{
				$value =  App::request()->$campo;
				$tpl->setVarBlock($bloque, "value", App::request()->$campo);
			}
			if($orden == "orden_detalle") $tpl->setVarBlock($bloque, "claseValidador", $row->clase_validador); 

			switch ($row->id_tipo_campo){
				case $i->SELECT:
					$valor = $this->getSelect($row, $tpl, $value, $campo);
					break;
				case $i->SELECT_COMA:
					$valor = $this->getSelectComa($row, $tpl, $value, $campo);
					break;
				case $i->DATE:
					$valor		= Date::parse($orm->$campo)->format(DateFormat::DATE_FORMAT_SHORT) ;
					$tpl->setVarBlock($bloque, "campo", $campo);
					$tpl->setVarBlock($bloque, "value", $valor);
					$valor		= $tpl->parseBlock($bloque);
					break;
				case $i->DATETIME:	
					$valor		= Date::parse($orm->$campo)->format(DateFormat::DATE_FORMAT_FULL_TIME) ;
					$tpl->setVarBlock($bloque, "campo", $campo);
					$tpl->setVarBlock($bloque, "value", $valor);
					$valor		= $tpl->parseBlock($bloque);
					break;
				case $i->PASSWORD: 
					$tpl->setVarBlock($bloque, "campo", $campo);
					$tpl->setVarBlock($bloque, "title", $descripcion);
					$valor		= $tpl->parseBlock($bloque);
					break;
				case $i->CHECK:
					$valor		= $orm->$campo;
					if($valor){
						$tpl->setVarBlock($bloque, "activo", "checked='checked'");
					}
					$tpl->setVarBlock($bloque, "campo", $campo);
					$tpl->setVarBlock($bloque, "value", 1);
					$valor		= $tpl->parseBlock($bloque, true);
					break; 
				case $i->TEXTAREA:
					$tam = explode(",",$row->extra);
					if(count($tam) == 2){
						$tpl->setVarBlock($bloque, "campo", $campo);
						$tpl->setVarBlock($bloque, "cols", $tam[0]);
						$tpl->setVarBlock($bloque, "rows", $tam[1]);
						$valor		= $tpl->parseBlock($bloque);
						break;
					}else{
						$tpl->setVarBlock($bloque, "cols","");
						$tpl->setVarBlock($bloque, "rows", "");
					}
				case $i->FILE:
				case $i->FILE_PREVIEW:
					$detail = "";
					$detail = $tpl->setVarBlock($bloque."_DETAIL","value",($value!="")?$value:"")
								->setVarBlock($bloque."_DETAIL","campo",$campo)
								->parseBlock("{$bloque}_DETAIL"); 
					$tpl->setVarBlock($bloque, "campo", $campo);
					$tpl->setVarBlock($bloque, "preview", $detail);
					$valor		= $tpl->parseBlock($bloque);
				default:
					$tpl->setVarBlock($bloque, "campo", $nombreCampo);
					$tpl->setVarBlock($bloque, "id_campo", $row->id_campo);
					$valor		= $tpl->parseBlock($bloque);
					break;
			}
			
			if( $row->id_tipo_campo == $i->HIDDEN ){
				$tmp .= $valor;
				$j--;
			}else{
				$tpl->setVarBlock("CAMPO", "valor", $valor);
				$tmp .= $tpl->parseBlock("CAMPO");
			}
			if($cxc == $j){
				$j 		 = 0;
				$tmp2	.= $tpl->setVarBlock("COLUMNAS", "campos", $tmp)
								->setVarBlock("COLUMNAS", "width", (int)100 /$columnas )->parseBlock("COLUMNAS");
				$tmp	 = "";
			}
			
			
		}
		if($tmp != ""){
			$tmp2	.= $tpl->setVarBlock("COLUMNAS", "campos", $tmp)->parseBlock("COLUMNAS");
		}
		
		
		return $tmp2.$this->getHiddenParams( $tpl );
	}
	
	protected function getHiddenParams( $tpl = null){
		if ($tpl == null )$tpl 	= new Template("admin_detail.tpl");
		$tmp					= "";	
		$params					= explode(",", App::request()->_params);
		
		if(count($params) > 0){
			foreach( $params as $val ){
				$tmp .= $tpl->setVarBlock("HIDDEN", "campo", $val)
					->setVarBlock("HIDDEN", "value", App::request()->$val)->parseBlock("HIDDEN");
			}
			$tmp .= $tpl->setVarBlock("HIDDEN", "campo", "_params")
					->setVarBlock("HIDDEN", "value", App::request()->_params)->parseBlock("HIDDEN");
	
		}
		
		return $tmp;
		
	}
	
	public function delete(){
		$orm 		= AdminLogic::getOrm();
		$orm->delete();
	}
	
	public function save(){
		$orm 			= AdminLogic::getORM();
		list($ds, $rs)	= AdminLogic::getCampos();
		$i18n  			= FACTORIE::getDefault()->AdminTiposCamposI18N();
		while($fila = $ds->next($rs)){
			$key = $fila->nombre;
			switch ($fila->id_tipo_campo){
				case $i18n->CHECK:
					if (App::request()->$key != null){
						$orm->$key = 1;
					}else{
						$orm->$key = 0;
					}
					break;
				case $i18n->DATE:
				case $i18n->DATETIME:
						$orm->$key= Date::parse(App::request()->$key)->format(DateFormat::DATE_FORMAT_SQL_FULL);
					break;
				case $i18n->PASSWORD:
					if(App::request()->$key){
						$orm->$key=md5(App::request()->$key);
					}
					break;
				case $i18n->FILE:
				case $i18n->FILE_PREVIEW:
						$anterior 	= $orm->$key;
						$filename = time();
						$orm->$key	= $fila->extra.FACTORIE::getDefault()->FileUploader()
										->setFileName($filename)
										->setDestination("../".$fila->extra)
										->upload($key);
						
						if($_FILES[$key]['tmp_name'] != ""){
							if($orm->$key === false ){
								throw new GenException("No ha subido");
							}else{
								@unlink("../".$anterior);
							}
						}else{
							$orm->$key= $anterior;
						}
					break;
				case $i18n->LABEL:
					break;
				default:
					
					if(App::request()->$key !== null){
						$orm->$key = App::request()->$key;
					}
			}
		}

		$orm->save();
		if(!AdminLogic::isNew()){
			$cadena = array();
			foreach($orm as $key => $value){
				$cadena[$key] = $value;
			}
			die(json_encode($cadena));
		}
	}
	
	public function getSelect($row, $tpl,$value, $campo){
		$class	= $row->extra;
		list($ds, $rs) = FACTORIE::getDefault()->$class()->getSelector();
		
		$combo = new ControlComboBox();
		$combo->setSelected( $value  );
		$combo->setSource($ds, $rs)->setName($campo)->setClass("formulario " . $row->class_validator)->setDefault(array(""=>""));
		
		return $combo->parse();
	}
	
	public function getSelectComa($row, $tpl, $value, $campo){
		$valores 	= explode(",", $row->extra);
		$array_temp	= array();
		
		foreach($valores as $val){
			$array_temp[$val] = $val;
		}
		
		$combo = new ControlComboBox();
		$combo->setSelected( $value  )->setDefault(array(""=>""));
		
		$combo->setSource($array_temp)->setName($campo)->setClass("formulario");
		return $combo->parse();
	}
	
	protected function getBotonera($tpl = null){
		$tpl				= (is_null($tpl))?new Template("admin_detail.tpl"):$tpl;
		
		$orm 				= AdminLogic::getORM();
		$filters 			= new HashTable();
		$filters->id_tabla 	= AdminLogic::getTable()->idTabla;
		
		list($ds,$rs)		= FACTORIE::getDefault()->AdminBotoneraRS()->sql($filters);
		
		$botones = "";
		while($row = $ds->next($rs)){
			$tpl->setVarBlock("BOTONERA_UNIDAD",$row->get());
			$tpl->setVarBlock("BOTONERA_UNIDAD","params",AdminLogic::getInheritedParameters($row->parametros));
			$botones .= $tpl->parseBlock("BOTONERA_UNIDAD");
		}
		
		$tpl->setVarBlock("BOTONERA","unidades",$botones);
		
		return $tpl->parseBlock("BOTONERA");
		
	}
	
	public function getBuscador(){
		
		$tpl 		= new Template("admin_detail.tpl");
		
		list($contenidos,$paginador) = $this->getList($tpl);
		
		$tpl->setVarBlock("BUSCADOR", "paginador", $paginador->getJs().$paginador->pagination());
		$tpl->setVarBlock("BUSCADOR", "cont", $contenidos);
		
		return $tpl->parseBlock("BUSCADOR");
	}
	
	public function getList($tpl = null){
		
		$tpl = (is_null($tpl))?new Template("admin_detail.tpl"):$tpl;
		
		$orm 		= FACTORIE::getDefault()->AdminCampos()->getByPk( App::request()->id_campo );
		$classRs	= $orm->extra;
		
		list($ds, $rs, $paginated)  = FACTORIE::getDefault()->$classRs()->getAjaxSelector(10, App::request());
		
		$paginated->setListContainer("ajax-container");
		$paginated->setPaginationContainer("ajax-footer");
		$paginated->setController("Admin.rpcSearch");
		$paginated->setType("html");
		
		$headers = $ds->getHeaders();
		$tmp		= "";
		foreach($headers as $header){
			$tmp	.=	$tpl->setVarBlock("ITEMS_BUSCADOR_COLUM", "value", $header)
							->parseBlock("ITEMS_BUSCADOR_COLUM");
		}
		$tpl->setVarBlock("BUSCADOR", "columnas", $tmp);
		$tmp		= "";
		while( $fila = $ds->next($rs)){
			$campos = $fila->get();
			$tmp	.= $tpl->setVarBlock("ITEMS_BUSCADOR", "value", $campos[1])
						->setVarBlock("ITEMS_BUSCADOR", "value_esc", addslashes($campos[0]))
						->setVarBlock("ITEMS_BUSCADOR", "campo", $orm->nombre)
						->parseBlock("ITEMS_BUSCADOR");
		}
		
		$cont = $tpl->setVarBlock("BUSCADOR_BOX", "items", $tmp)->parseBlock("BUSCADOR_BOX");
		
		return array($cont,$paginated);
	}
}