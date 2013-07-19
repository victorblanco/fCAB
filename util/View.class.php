<?php

class View {

	public function __construct(){


	}

	static function getView(){
			if (App::request()->view){
				return App::request()->view;
			}else{
				return "html";
			}
	}
	static function isPDF(){
		if (App::request()->view == "pdf"){
			return true;
		}else{
			return false;
		}
	}
	static function isXLS(){
		if (App::request()->view == "xls"){
			return true;
		}else{
			return false;
		}

	}
	static function isHtml(){
		if (App::request()->view == "html" || !isset(App::request()->view)){
			return true;
		}else{
			return false;
		}

	}

}
