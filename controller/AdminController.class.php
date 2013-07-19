<?php


class AdminController extends Controller{
	
	protected $miga;
	
	public function __construct(){
		parent::__construct("admin.tpl");
	}
	
	//TODO extender
	/***
	 * Metodo extendido para seguridad por tabla
	 */ 
	public function secure(){
		if(UserLogic::isAllowedAdmin()){
			switch (App::getAction()){
				case "defaultAction":
				case "adminAction":
				case "busquedaAction":
				case "rpcSearchAction":
					break;
				default:
					AdminLogic::init();	
				break;
			}
		}else{
			UserLogic::notAllowed();
		}
			
	}
	
	
	public function busquedaAction( $cont ){
		echo utf8_encode(FACTORIE::getDefault()->AdminDetailOU()->getBuscador());
		die;
		/*$cont->menu		= FACTORIE::getDefault()->AdminListTablesOU()->getOutput();
		$cont->body 	= FACTORIE::getDefault()->AdminBodyOU()->getOutput();
		$cont->header	= FACTORIE::getDefault()->AdminHeaderOU()->getOutput();*/
	}
	
	/**
	 * Listado del admin
	 * 
	 * @param unknown_type $cont
	 */
	public function defaultAction( $cont ){
		
		$cont->menu		= FACTORIE::getDefault()->AdminListTablesOU()->getOutput();
		$cont->body 	= FACTORIE::getDefault()->AdminBodyOU()->getOutput();
		$cont->header	= FACTORIE::getDefault()->AdminHeaderOU()->getOutput();
	}
	
	
	
	/**
	 * 
	 * Detalle del admin
	 * 
	 * @param unknown_type $cont
	 */
	public function detailAction( $cont ){
	
		$cont->menu		= FACTORIE::getDefault()->AdminListTablesOU()->getOutput();
		$cont->body 	= FACTORIE::getDefault()->AdminDetailOU()->getOutput();
			$cont->header	= FACTORIE::getDefault()->AdminHeaderOU()->getOutput();
	}	
	
	public function ajaxDetailAction(){
		die(utf8_encode(FACTORIE::getDefault()->AdminListTablesOU()->getOutput()));
	}
	
	public function saveAction( $cont ){
			FACTORIE::getDefault()->AdminDetailOU()->save();
			App::redirect("app/Admin.list?TABLE=".AdminLogic::getTable()->idTabla."&_filter_adm=1".AdminLogic::getInheritedParameters());
	}
	public function deleteAction( $cont ){
			FACTORIE::getDefault()->AdminDetailOU()->delete();
			App::redirect("app/Admin.list?TABLE=".AdminLogic::getTable()->idTabla."&_filter_adm=1".AdminLogic::getInheritedParameters());
	}
	
	public function getListAction( $cont ){
		header("Content-Type: text/html; charset=utf-8 ");
		die(json_encode(FACTORIE::getDefault()->AdminListOU()->getList()));
	}
	
	public function listAction( $cont ){
		
		$cont->menu 	= FACTORIE::getDefault()->AdminListTablesOU()->getOutput();
		$cont->body		= FACTORIE::getDefault()->AdminListOU()->getOutput();
		$cont->header	= FACTORIE::getDefault()->AdminHeaderOU()->getOutput();
	}
	
	protected function getFullAdminList(){
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
	
	protected function adminAction( $cont){
		$cont->body = $this->getFullAdminList();
	
	}
	
	public function rpcSearchAction( $cont ){
		header("Content-Type: text/html; charset=utf-8 ");
		
		$response = array();
		list($html,$paginator) = FACTORIE::getDefault()->AdminDetailOU()->getList();
		
		$response[0] = utf8_encode($html);
		$response[1] = utf8_encode($paginator->pagination());
		die(json_encode($response));
		
	}
	
	
}