<?php

class DBTranslator extends Object{
	protected $data = array();
	protected $dominio = "";
	/**
	 * 
	 * @var string 
	 * @desc Se utiliza para saber el domino de la anterior traduccion para el dóminio _global
	 * 
	 */
	protected $lastDomain = "";
	
	public function saveAction($cont){
		$traductor 			= Traductor::getDefault()->getByPk(App::request()->clave, App::request()->dominio);
		if (is_null($traductor)){
			$traductor = Traductor::getDefault();
		}
		$traductor->domain 	= App::request()->dominio;
		$traductor->key_ 	= App::request()->clave;
		$traductor->txt		= App::request()->txt;
		$traductor->save();
		$this->defaultAction($cont, $http, $model);
	}
	
	function setDomain($dominio ){
		$this->dominio = $dominio;
		Debug::add("DBTRANSLATOR. Recogiendo traducciones del domino $dominio ");
		$sql	= "SELECT * FROM ".Traductor::getTableByLocale()." where domain = '$dominio' or domain = '_global' order by domain ASC";
		$ds 	= Traductor::getDS();
		$resultado = $ds->exec($sql);
		while ($fila = $ds->next($resultado)){
			$this->data[$fila->key_][0] = $fila->txt;	
			$this->data[$fila->key_][1] = $fila->domain;		
		}		
	}
	
	function getDomain(){
		return $this->dominio;
		
	}
	
	function getLastDomain(){
		return $this->lastDomain;
	}
	
	function __get($key){
		$trad 	= "";
		$isTrad	= false;

		if ($this->data[$key][0]){
			$this->lastDomain	= $this->data[$key][1];
			$trad 				= $this->data[$key][0];
			$isTrad 			= true;
		}else{
			$trad 	= $key;
			$isTrad = false;
			$this->lastDomain = App::getController();
		}		
		if (App::isITT()){
			return $this->getTranslation($trad, $key, $isTrad);
		}else{
			return $trad;
		}
	}
	
	private function getTranslation($txt, $clave, $issTrad, $dominio = ""){
			$tpl_trads = new Template("ITT.tpl");
			$tpl_trads->setVar("txt", "$txt");
			$tpl_trads->setVar("dominio", $this->getLastDomain());
			
			$tpl_trads->setVar("clave", $clave);
			if ( ! $issTrad ){
				$tpl_trads->setVar("style", $tpl_trads->parseBlock("SIN_TRADUCCION"));
			}else{
				$tpl_trads->setVar("style", $tpl_trads->parseBlock("CON_TRADUCCION"));
			}
			return $tpl_trads->parse();
	}
	
}