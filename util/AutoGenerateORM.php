<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

/*require_once LIBRARY . "Object.php";
require_once LIBRARY . "FileWriter.php";
require_once LIBRARY . "Template.php";*/

	class AutoGenerateORM extends Object{
		
		protected $db;
		
		protected $ormPath = ORM;
		
		protected $tpl_name = null;
		
		public function __construct($db){
			parent::__construct();
			$this->db = $db;
		}
		
		public function __destruct(){
			unset($this);
		}
	
		public function __set($field, $value){
			$this->$field = $value;
		}
		
		public function __get($field){
			return $this->$field;
		}
		
		protected function creoAdminTabla( $tabla ){
			if ($tabla != "AdminBotonera" && $tabla != "AdminCampos" && $tabla != "AdminTablas" && $tabla != "AdminTiposCampos"){
				return true;
			}else {
				return false;
			}
		}
		
		
		public function execute(){
			
			$sql_show = "show tables;";
			
			
			$ex = $this->db->exec($sql_show);
			while ($table = $this->db->next($ex)){
				
				$t_name = $table->current();
				$pk 	= array();
				$fields = array();
				$clase 	=str_replace(" ", "" , ucwords(strtolower(str_replace("_", " ", $t_name))));

				if (App::request()->table != null && App::request()->table != $t_name){
					continue;
				}
				
				$tpl = new Template("AutoGenerateORM.tpl", tpl_dir, tpl_pre);
				
				$sql_desc = sprintf("desc %s;",$t_name);	
				$ex2 = $this->db->exec($sql_desc);
				/**
				 * Insercion en la Tabla de Admin
				 */
				if (App::request()->admin && $this->creoAdminTabla( $clase )){
					$tabla 					= FACTORIE::getDefault()->AdminTablas();
					$tabla->idTabla			= null;
					$tabla->description 	= $clase;
					$tabla->columnas		= 1;
					$tabla->insert();
				}
				$i = 5;
				while ($field = $this->db->next($ex2)){
					$f = explode("_",strtolower($field->Field));
					
					$temp = null;
					
					if(is_array($f)){
						$cont = 0;
						foreach($f as $v){
							if($cont != 0)
								 $temp .= ucfirst($v);
							else $temp = $v;
							$cont = 1;		
						}
					}
					
					$fields[$temp] =  strtolower($field->Field);
												
					/**
					 * Insercion en la Tabla de Admin
					 */
					if (App::request()->admin && $this->creoAdminTabla( $clase )){
						$orm 				= FACTORIE::getDefault()->AdminCampos();
						$orm->idCampo		= null;
						$orm->nombre 		= $temp;
						$orm->descripcion	= $temp;
						$orm->idTipoCampo	= 1;
						$orm->idTabla		= $tabla->idTabla;
						$orm->ordenDetalle	= $i;
						$orm->ordenLista	= $i;
						$orm->insert();
					}
					if ($field->Key == 'PRI') $pk[$temp] =  strtolower($field->Field);
					$i = $i +5;
				}
				
				$temp = null;
				
				foreach ($fields as $k => $v){
					$tpl->setVarBlock("FIELD","name",$k);	
					$tpl->setVarBlock("FIELD","dbname",$v);	
					
					if(!is_null($temp)) $tpl->setVarBlock("FIELD","coma",",");	
					$temp .= $tpl->parseBlock("FIELD",1);
				}
				
				$tpl->setVar("fields",$temp);
				
				$tpl->setVar("table",$t_name);
				$tpl->setVar("clase",$clase);
				
				
				$temp = null;
				foreach ($fields as $k => $v){
					$tpl->setVarBlock("VALUE","name",$k);	
					
					if(!is_null($temp)) $tpl->setVarBlock("VALUE","coma",",");	
					$temp .= $tpl->parseBlock("VALUE",1);
				}
				
				$tpl->setVar("values",$temp);
				
				$temp = null;
				foreach ($pk as $k => $v){
					$tpl->setVarBlock("PK","name",$k);	
					
					if(!is_null($temp)) $tpl->setVarBlock("PK","coma",",");	
					$temp .= $tpl->parseBlock("PK",1);
				}
				
				$tpl->setVar("pks",$temp);
				
				$cont = $tpl->parse();	
				try{	
					$fw = new FileWriter("propias/orm/$clase.class.php");
					@$fw->write($cont,'w');
				}catch(Exception $e){
					echo "Error en "."propias/orm/$clase.class.php";
				}
			}
			
			
		}
	}

?>
