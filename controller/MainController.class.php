<?php


class MainController extends Controller{

	
	public function changeestudioAction(HashTable $cont, Http $http, Model $model){
		if( Http::post()->id_estudio) {
			Session::register("id_estudio");
			Session::set("id_estudio" , Http::post()->id_estudio);
		}
		$this->defaultAction($cont, $http, $model);
		
	}
	public function defaultAction(HashTable $cont, Http $http, Model $model){
			
		$this->controls->ControlToolbar->addButtonPrimary("pdf","img/img_btn_pdf.png","window.location='app/Main?view=pdf&id_centro=".Http::r()->id_centro."'","PDF");
		$cont->toolbar = $this->controls->ControlToolbar->parse();
		$this->preload_img = $this->controls->ControlToolbar->getPreloadImg();
	
		$cont->body = $this->clases->ResumenOU->getOutput();
	
		
	}
	
	
	
}
