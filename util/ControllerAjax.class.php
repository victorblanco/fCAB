<?php

class ControllerAjax extends Controller{

	

	public function getOutput($action){
		$cont = new HashTable();
		$this->__default($cont);
		$view = $this->$action($cont);
		return $view;
	}
}

