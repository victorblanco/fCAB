<?php


class ConfigController extends Controller{
	public function secure(){
		if (!UserLogic::isAllowedConfig()){
			UserLogic::notAllowed();
		}
	}
	public function __construct(){
		parent::__construct("Controller_gen.tpl");
	}
	
	function defaultAction (HashTable $cont){
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("GUARDAR","img/img_btn_guardar.png","document.formulario.submit();","Guardar");
		$cont->body = ControlForm::getDefault()
				->setAction(SUB_CARPETA."app/Config.save")
				->setMethod("POST")
				->setName("formulario")
				->setCONTENT(FACTORIE::getDefault()->XmlList()->setXml(App::getConfigFile())->getOutput())
				->parse();
	
		$cont->toolbar = FACTORIE::getDefault()->ControlToolbar()->parse();

	}
	function saveAction (HashTable $cont){
		FACTORIE::getDefault()->XmlList()->setXml(App::getConfigFile())->save();
		//$this->defaultAction($cont, $http, $model);
		App::redirect("app/Config");
	}
}
