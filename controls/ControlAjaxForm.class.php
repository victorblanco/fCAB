<?php

class ControlAjaxForm extends ControlForm implements IFactory{
	
	protected $disparador;
	protected $event;
	
	public static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ControlAjaxForm();
			return $i;
	}
	
	public function setDisparador($disparador, $event){
		$this->disparador 	= $disparador;
		$this->event		= $event;
		return $this;
	}

	public function parse(){
		$ajax 		= new ControlAjax();
		$ajax_tpl 	= $ajax	->setName($this->name)
					->setURL($this->action)
					->setExtraAjax("data: $('#".$this->id."').serialize(),")
					->setType($this->method)
					->setDisparador($this->disparador, $this->event)
					->setDivLoading("#contentAjax", "'Cargando'")
					->setResponse("#contentAjax")
					->parse(); 
		$formulario 	= parent::parse();
		
		return $ajax_tpl .'<div id="contentAjax" style="background: #CCCCCC" ></div>'. $formulario;
	}

	public function setLoading($loading){
		$this->loading = $loading;
		return $this;
	}


}


?>
