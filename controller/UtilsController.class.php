<?php

class UtilsController extends Controller{

	public function ormGenerateAction(HashTable $cont){
		require("core/util/AutoGenerateORM.php");
		if (App::request()->ds){
			$o = new AutoGenerateORM(App::getDS(App::request()->ds));
		}else{
			$o = new AutoGenerateORM(App::getDS("DEFAULT"));
		}
		$o->execute();


	}
	public function secure(){
		if (!UserLogic::isAllowedUtils()){
			UserLogic::notAllowed();
		}
		if (! (ENTORNO == DESARROLLO)){
			throw new Exception("Error de serguridad, esto solo se puede utiliza en el entorno de desarrollo");
		}

	}
	
	public function rsGenerateAction(HashTable $cont){
		require("core/util/AutoGenerateRS.class.php");
		if (App::request()->ds){
			$o = new AutoGenerateRS(App::getDS(App::request()->ds));
		}else{
			$o = new AutoGenerateRS(App::getDS("DEFAULT"));
		}

		$o->exec();


	}

}
