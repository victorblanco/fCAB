<?php


class IttController extends Controller{
	
	public function __construct(){
		parent::__construct("Controller_gen.tpl");
	}

	public function secure(){
		if (!UserLogic::isAllowedItt()){
			UserLogic::notAllowed();
		}
		if (!(App::request()->clave && App::request()->dominio) && App::getAction() != "desactivaAction" && App::getAction() != "activaAction"){
			throw new ParamsException("Necesita los parámetros Clave y dominio");
		}

	}

	public function saveAction($cont){
		$traductor 			= Traductor::getDefault()->getByPk(App::request()->clave, App::request()->dominio);
		if (is_null($traductor)){
			$traductor = Traductor::getDefault();
		}
		$traductor->domain 	= App::request()->dominio;
		$traductor->key_ 	= App::request()->clave;
		$traductor->txt		= App::request()->txt;
		$traductor->save();
		$this->defaultAction($cont, $http, $model);
	}

	public function saveAllAction($cont){

		foreach(App::request()->clave as $key => $value){
			$traductor 			= Traductor::getDefault()->getByPk(App::request()->clave[$key], App::request()->dominio[$key]);
			if (is_null($traductor)){
				$traductor = Traductor::getDefault();
			}
			$traductor->domain 	= App::request()->dominio[$key];
			$traductor->key_ 	= App::request()->clave[$key];
			$traductor->txt		= App::request()->txt[$key];
			$traductor->save();
		}
		$this->listTranslationAction($cont);
	}

	public function defaultAction($cont){
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("GUARDAR","img/img_btn_guardar.png","document.formulario.submit();","Save");
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("Listado_Traducciones","img/img_btn_guardar.png","window.location='app/Itt.listTranslation?clave=1&dominio=".App::request()->dominio."';","Listado Traducciones");

		$traduccion = Traductor::getDefault()->getByPk(App::request()->clave, App::request()->dominio);

		$formulario = ControlInput::getDefault()->setName("clave")->setValue(App::request()->clave)->parse();
		$formulario .= ControlInput::getDefault()->setName("dominio")->setValue(App::request()->dominio)->parse();
		$formulario .= ControlInput::getDefault()->setName("txt")->setValue($traduccion->txt)->parse();

		$cont->body = ControlForm::getDefault()
		->setAction("app/Itt.save")
		->setMethod("POST")
		->setName("formulario")
		->setCONTENT( $formulario )->parse();
		$cont->toolbar = FACTORIE::getDefault()->ControlToolbar()->parse();

	}

	public function listTranslationAction($cont){
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("GUARDAR","img/img_btn_guardar.png","document.formulario.submit();","Save");

		$dominio 	= App::request()->dominio;
		$sql		= "SELECT * FROM ".Traductor::getTableByLocale()." where domain = '$dominio'";
		$ds 		= Traductor::getDS();
		$resultado 	= $ds->exec($sql);
		$formulario = array();
		$i 			=0;
		while ($fila = $ds->next($resultado)){
			$formulario[$i]["key"] 		= ControlInput::getDefault()->setName("clave[]")->setValue($fila->key_)->parse();
			$formulario[$i]["domain"] 	= ControlInput::getDefault()->setName("dominio[]")->setValue($fila->domain)->parse();
			$formulario[$i]["txt"]		= ControlInput::getDefault()->setName("txt[]")->setValue($fila->txt)->parse();
			$i++;
		}
		FACTORIE::getDefault()->Search()->setHeaders(new HashTable("Clave","Domain","Txt"));
		FACTORIE::getDefault()->Search()->setRS($formulario);
		FACTORIE::getDefault()->Search()->setInput(false);
		FACTORIE::getDefault()->Search()->setFields(array("key", "domain", "txt"));
		$search = FACTORIE::getDefault()->Search()->getOutput();
		$cont->body = ControlForm::getDefault()
		->setAction("app/Itt.saveAll")
		->setMethod("POST")
		->setName("formulario")
		->setCONTENT( $search )->parse();
		$cont->toolbar = FACTORIE::getDefault()->ControlToolbar()->parse();

	}

	public function activaAction($cont) {
		Session::set("_ITT_", 1);
	}
	public function desactivaAction($cont) {
		Session::set("_ITT_", 0);
	}

}
