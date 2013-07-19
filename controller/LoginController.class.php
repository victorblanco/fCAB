<?php

class LoginController extends Controller {

	function __construct() {
	  parent::__construct("login.tpl");
	}

	public function loginAction(HashTable $cont, Http $http, Model $model){
		$filters = new HashTable();
		$filters->usuario = Http::post()->user;
		$filters->password = Http::post()->pw;
		$query = $this->rs->UsuariosRS->sql($filters);	
		$db =  App::getDS("DEFAULT");
		$resultado = $db->exec($query);
		if ($fila = $db->next($resultado)){
			UsserData::getDefault()->load($fila->id);
				header("Location: ".SUB_CARPETA."app/en/Frame");
		}else{
			//echo "nop net";
		}
		$this->defaultAction($cont, $http,$model);
	}
	
	public function ormAction (HashTable $cont, Http $http, Model $model){
	//	$ds = App::getDS();
	//	$d = new AutoGenerateORM($ds);
		//$d->execute();
	}
	public function logoutAction(HashTable $cont, Http $http, Model $model){
		Session::logoutSession();
		$this->defaultAction( $cont,  $http,  $model);
		
	}
	
	public function secure(){}


	public function defaultAction(HashTable $cont, Http $http, Model $model){
			
		try{
			$this->setCss(new HashTable("tema_azul.css"));
			self::$tpl->setVarBlock("FORM","INPUT_user",ControlInput::getDefault()->setType("text")->setName("user")->setClass("tbusuariologin")->parse());
			self::$tpl->setVarBlock("FORM","INPUT_pw",ControlInput::getDefault()->setType("password")->setName("pw")->setClass("tbusuariologin")->parse());
			self::$tpl->setVarBlock("FORM","INPUT_button",ControlInput::getDefault()->setType("submit")->setValue("Login")->setName("sb")->setClass("tbtextobtnlogin")->parse());
			self::$tpl->setVar("FORM_LOGIN", ControlForm::getDefault()->setMethod("POST")->setAction("app/en/Login.login")->setName("formulario")->setCONTENT(self::$tpl->parseBlock("FORM"))->parse());
		}catch(Exception $e){
			Debug::add($e);
		}


	}

}
