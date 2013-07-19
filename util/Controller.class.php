<?php

class Controller extends Object{

	protected static $css;
	protected static $js;
	protected static $contents;
	protected static $tpl;
	protected static $title = null;
	protected static $keywords = null;
	protected static $description = null;
	protected $rs = null;
	protected $clases = null;
	protected $mode = "html";
	protected $domain;


	public function __construct($tplName = 'Controller.tpl'){
		parent::__construct();
		$this->secure();
		$this->activa();
		$this->headers();

		self::$contents = new HashTable();
		self::$js 		= new HashTable();
		self::$css 		= new HashTable();
		self::$tpl 		= new Template($tplName ,tpl_dir, tpl_pre);
		if (!is_null(App::request()->language)){
			App::setLocale(App::request()->language);

		}

	}

	protected function activa(){
		if(UserLogic::isAllowedItt()){
			if (!is_null(App::request()->itt) && App::request()->itt == 1){
				Session::set("_ITT_", 1);
			}elseif(!is_null(App::request()->itt ) && App::request()->itt == 0){
				Session::set("_ITT_", 0);
			}elseif(!is_null(App::request()->itt ) && App::request()->itt == 2){
				Session::set("_ITT_", 2);
			}
		}else{
			Session::set("_ITT_", 0);
		}
	}

	protected function secure(){
		if (SEGURIDAD_PAGINA){
			if ( !UserLogic::isLogged()){
				UserLogic::notAllowed();
				exit;
			}
		}

	}

	public function __destruct(){ 
		unset($this);
	}

	protected static function setJs(HashTable $js){
		self::$js = $js;
	}

	protected static function setCss(HashTable $css){
		self::$css = $css;
	}

	protected static function setContent(HashTable $content){
		self::$contents = $content;
	}

	public static function setTitle($value){
		self::$title = $value;
	}

	public static function setDescription($value){
		self::$description = $value;
	}

	public static function setKeywords($value){
		self::$keywords = $value;
	}


	protected function headers(){
		switch (App::request()->view){
			case "xml":
				header("Content-Type:application/xml;charset=UTF-8");
				break;
			case "html":
				header("Content-type: text/html; charset=utf-8",true);
				break;
			case "pdf":
				break;
			case "xls":
				header("Content-Type: application/vnd.ms-excel");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("content-disposition: attachment;filename=".$this->getTitleFile().".xls");
				break;
		}
	}
	protected function getTitleFile(){
		if (self::$title){
			return self::$title;
		}else{
			return APPNAME;
		}
	}

	public function __default($cont){

	}

	public function getOutput($action){
		$cont = new HashTable();
		$this->__default($cont);
		$ajax_content = $this->$action($cont);
		if($ajax_content){
				return $ajax_content;
		}

		self::setContent($cont);


		Debug::add("NOTICIA: Enviando cabeceras desde " .get_class($this). "->action()");
		
		self::$tpl->setVar("BASE", PROTOCOL.$_SERVER['HTTP_HOST'].SUB_CARPETA);
		# Parseamos los js
		$temp_js = null;
		foreach(self::$js as $js){
			self::$tpl->setVarBlock("JS","js",$js);
			Debug::add("NOTICIA: Agregando Js a " .get_class($this). "->action() [$js]");
			$temp_js .= self::$tpl->parseBlock("JS",1);
		}
		self::$tpl->setVar("js",$temp_js);

		# Parseamos los css
		$temp_css = null;
		foreach(self::$css as $css){
			self::$tpl->setVarBlock("CSS","css",$css);
			Debug::add("NOTICIA: Agregando CSS a " .get_class($this). "->action() [$css]");
			$temp_css .= self::$tpl->parseBlock("CSS",1);
		}
		self::$tpl->setVar("css",$temp_css);


		# Parseamos los contents
		foreach(self::$contents as $key => $content){
			try{
				if(!is_object($content)){
					self::$tpl->setVar($key,$content);
					Debug::add("NOTICIA: Agregando Content a " .get_class($this). "->action() [$key]");
				}else{
					Debug::add(@$content->getMessage(). " Capturado desde " .get_class($this). "-> action() ");
				}
			}catch(Exception $e){
				Debug::add(@$content->getMessage(). " Capturado desde " .get_class($this). "-> action() ");
			}
		}

		$this->setDataPage();

		self::$tpl->setVar("title",self::$title);
		self::$tpl->setVar("description",self::$description);
		self::$tpl->setVar("keywords",self::$keywords);
		self::$tpl->setVar("language",App::getLocale());

		Debug::add("NOTICIA: Final del proceso " .get_class($this). "-> action()  ....");
		return self::$tpl->parse();

	}

	protected function setDataPage(){}


}

