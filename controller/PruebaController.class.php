<?php
class PruebaController extends Controller{
	function ejemploAction(HashTable $cont, Http $http, Model $model){
		if (App::request()->hola){
			$d = new Curl();
			echo $d->setUrl("www.google.es/search?q=".App::request()->hola)->get();
			$d->close();
			die();
		}
		echo "hola";die();
		
	}
	public function secure(){}
	public function defaultAction(HashTable $cont, Http $http, Model $model){
		$this->setJS(new HashTable("js/jquery.js"));
		$this->controls->ControlToolbar->addButtonPrimary("GUARDAR","img/img_btn_guardar.png","undefined","Guardar");
		$cont->body  = $this->controls->ControlAjax
							->setName("ajax_prueba")
							->setUrl(SUB_CARPETA."app/Prueba.ejemplo")
							->setExtra("data: $('#texto').serialize(),")
							->setDisparador("#GUARDAR", "click")
							->setDivLoading("#contentAjax", "'Cargando'")
							->setResponse("#contentAjax")->parse();
		$cont->body .= $this->controls->ControlInput->setType("text")->setId("texto")->setName("hola")->parse();
		$cont->body .= '<div id="contentAjax" style="background: #CCCCCC" ></div>';
		$cont->toolbar = $this->controls->ControlToolbar->parse(); 
	}
}
