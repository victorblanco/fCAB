<?php

class OptimizeController extends Controller{
	protected $css_ = "";
	protected $img_ = "";
	function processAction(HashTable $cont, Http $http, $model){
		
		$c = new Curl();
		$txt = $c->setUrl(App::request()->url)->get();
		
		$patron = "/class=\s*[\"|\'](.*?)\s*[\"|\']/i";
		preg_match_all( '/<\s*IMG\s*\S*src=\s*[\"|\'](.*?)\s*[\"|\']/i', $txt, $ret2); 
		preg_match_all($patron, $txt, $ret);
		
		
		$ret 	= array_unique ($ret[1]);
		$ret2 	= array_unique($ret2[1]);
		
		//CSS
		$this->clases->Search->setHeaders(new HashTable("CSS"));
		$this->clases->Search->setRS($ret);
		$this->clases->Search->setInput(false);
		$this->css_ = $this->clases->Search->getOutput();
		
		
		//IMG
		$se	= new Search();
		$se->setHeaders(new HashTable("IMG"));
		$se->setRS($ret2);
		$se->setInput(false);
		$this->img_ = $se->getOutput();
		
		
		$c->close();
		$this->defaultAction($cont, $http, $model);
		
	}
	
	function defaultAction($cont, $http, $model){
		$this->controls->ControlToolbar->addButtonPrimary("GUARDAR","img/img_btn_guardar.png","document.formulario.submit();","Guardar");
		
		$tpl 	= new Template("Optimize.tpl");
		$tpl->setVar("INPUT_url", ControlForm::getDefault()->setMethod("POST")->setName("formulario")->setAction("app/Optimize.process")->setCONTENT(ControlInput::getDefault()->setName("url")->setValue(App::request()->url)->parse())->parse());
		$tpl->setVar("CSS", $this->css_);
		$tpl->setVar("IMG", $this->img_);
		$cont->toolbar = $this->controls->ControlToolbar->parse();
		$cont->body = $tpl->parse();
	}
}
