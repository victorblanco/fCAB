<?php


class AutoGenerateRS extends Object{

	protected $db;

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


	public function exec(){

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
			
				
			$tpl = new Template("AutoGenerateRS.tpl");
				
			$sql_desc = sprintf("desc %s;",$t_name);
			$ex2 = $this->db->exec($sql_desc);
				
			$temp = null;
			while ($field = $this->db->next($ex2)){
				$f = $field->Field;
				$temp .= $tpl->setVarBlock("ROW","campo",$f)->parseBlock("ROW",1);
			}
			$tpl->setVar("rows",$temp);
			$tpl->setVar("clase",$clase);
				
			$cont = $tpl->parse();
				
			$rs = "propias/rs/";
			if ( !$rs ) throw new Exception("No se ha definido el directorio para crear los RS en conf.xml [autogenerate_rs_dir]");
			try{
				$fw = new FileWriter($rs."$clase"."RS.class.php");
				@$fw->write($cont,'w');
			}catch (Exception $e){
				Debug::add("Error en la escritura en el archivo".$rs.$clase."RS.class.php" );
			}
		}
	}
}