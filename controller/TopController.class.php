<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class TopController extends Controller{

	function __construct() {
		# El parametro puede ser siempre el mismo porque puede ser el template
		# de nuestra pagina que la montara el controler
		# es versatil porque el tpl puede ser un xml y podriamos dar la salida en xml
		parent::__construct("void.tpl");
	}
	
	protected function headers(){
		//header("Content-type: text/html;",true);
		# Si tenemos que enviar cabeceras se deben hacer en este mï¿½todo
		# es invocado automaticamente antes de producir la salida
	}
	
	
	
	public function defaultAction(HashTable $cont, Http $http, Model $model){
		//self::setJs(new HashTable("./js/jquery.js"));
		
		$cont->cont 	= $this->clases->TopOU->getOutput();
	
	}
	
	
	
}

?>
