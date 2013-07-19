<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class FrameController extends Controller{

	function __construct() {
		# El parametro puede ser siempre el mismo porque puede ser el template
		# de nuestra pagina que la montara el controler
		# es versatil porque el tpl puede ser un xml y podriamos dar la salida en xml
		parent::__construct("FrameController.tpl");
	}
	
	protected function headers(){
		header("Content-type: text/html;",true);
		# Si tenemos que enviar cabeceras se deben hacer en este método
		# es invocado automaticamente antes de producir la salida
	}
	
	
	
	/*
	* @Description: Es el default action
	* @Params:  $cont, variables del template del controller
	*			$http, objeto http que trae los valores del POST , GET, SERVER
	*			$model, xml para crear un model y dar salidas en xml
	* @Return, Void o String (Que corresponde con el nombre del template xslt)
	**/
	public function defaultAction(HashTable $cont, Http $http, Model $model){
		//self::setJs(new HashTable("./js/jquery.js"));
		
		
		/*
		$cont->left1 	= $this->clases->CategoriasOU->getOutput();
		$cont->left2 	= $this->clases->LoginOU->getOutput();
		*/

		
		/*$o = new AutoGenerateORM(App::getDS());
		$o->execute();
		*/
		
		/*
		
		VICTOR: 
				Esto es un ejemplo de como se van 
				agregando los contenidos a la controller
				
				
		
		$cont->top1 	= $this->clases->MenuTopOU->getOutput();
		$cont->top2 	= $this->clases->LanguageOU->getOutput();
				
		$cont->left1 	= $this->clases->CategoriasOU->getOutput();
		$cont->left2 	= $this->clases->BuscadorEscortOU->getOutput();
		
		$cont->right1 	= $this->clases->LoginOU->getOutput();
		
		# Para mostrar el menu privado comprobamos primeramente
		# si lo podemos mostrar
		if(UsserData::getDefault()->isLogged())
			$cont->right1 	= $this->clases->PrivateMenuOU->getOutput();
				
		$cont->footer1 	= $this->clases->MenuFooterOU->getOutput();
		
		$cont->cont1 	= $this->clases->ListadoEscortOU->getOutput();
		
		
		*/
	
	}
	
	
	
}

?>
