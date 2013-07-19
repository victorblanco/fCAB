<?php
/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: Fernando Manero
 *	Date: 04/08/2008
 *	Company:
 */



/**
 *	@Description: Esta clase se encarga de calcular la paginacion de una query,
 *	haciendo append del html resultante sobre la capa page-ajax
 *
 */
class AjaxAppenderPaginator extends Paginator{

	protected $varName 		= 'xpage';
	protected $list_container	= 'ajax-container';
	protected $pagination_container	= 'ajax-pagination';
	protected $controller = "RPC";
	protected $type = "append";
	protected $max_pages = 0;
	protected $function_prefix;
	protected $paginationPages = 5;
	protected $link = 0;
	protected $div_loading = ""; 

	function __construct(Db $dbObject, $sql, $regPorPagina, HashTable $params = null, $varName = 'xpage', $list_container = 'ajax-container', $pagination_container = 'ajax-pagination'){
		//parent::__construct();
		$this->db			= &$dbObject;
		$this->sql 			= $sql;
		$this->sqlCount 	= $sql;
		$this->regPorPagina	= $regPorPagina;
		$this->varName 		= $varName;
		$this->list_container	= $list_container;
		$this->pagination_container	= $pagination_container;
		$this->function_prefix = str_replace("-","_",$this->pagination_container);
		$this->type = "append";

		$query_vars = array();
		if(is_object($params)){

			foreach ($params as $name => $value){
				if($name == $this->varName) continue;
				//$query_vars[] = $name .'='.urlencode($value);
				if(is_array($value)){
					foreach ($value as $val){
						$query_vars[] = $name .'[]='.urlencode($val);
					}
				}else{
					$query_vars[] = $name .'='.urlencode($value);
				}
			}

			if(!is_array($query_vars)) return null;

			$query = implode('&', $query_vars);
			$this->params = "&".$query;

		}

	}

	public function setListContainer($value){
		$this->list_container = (is_null($value))?'ajax-container':$value;
		return $this;
	}
	
	public function setPaginationContainer($value){
		$this->pagination_container = (is_null($value))?'ajax-pagination':$value;
		$this->function_prefix = str_replace("-","_",$this->pagination_container);
		return $this;
	}
	
	public function setController($value){
		$this->controller = (is_null($value))?'RPC':$value;
		return $this;
	}
	
	public function setType($value){
		$this->type = (is_null($value) || !in_array($value,array("append","html")))?'append':$value;
		return $this;
	}
	
	public function getJs(){
		$tpl =  new Template("ajax_appender.tpl");

		
		$tpl->setVarBlock("JS","controller",$this->controller);
		$tpl->setVarBlock("JS","type",$this->type);
		$tpl->setVarBlock("JS","list_container",$this->list_container);
		$tpl->setVarBlock("JS","pagination_container",$this->pagination_container);
		$tpl->setVarBlock("JS","function_prefix",$this->function_prefix);
		$tpl->setVarBlock("JS","txt_sanitized", ($this->link_old));

		
		return $tpl->parseBlock("JS");
	}
	
	public function setMaxPages($value){
		$this->max_pages = (is_numeric($value))?$value:0;
		return $this;
	}
	
	public function pagination(){
		Debug::add(__CLASS__.": Paginando por ajax tipo {$this->type} y controller {$this->controller}");
		$tpl =  new Template("ajax_appender.tpl");
		if($this->getTotalPages() > 0){
			switch($this->type){
				case "html":
					return $this->paginationHtml($tpl);
					break;
				case "append":
					return $this->paginationAppend($tpl);
					break;
					
			}
		}else{
			return "";
		}
	}
	
	protected function paginationAppend($tpl){
		if ($this->getNextLink()){
			$link .= $this->createlink($this->getNextLink(),$tpl->parseBlock("SIGUIENTE_".strtoupper($this->type)), $tpl, $this->controller);
		}
		if($link != "" && (($this->max_pages == 0) || (($this->getPage()+1) <= $this->max_pages))){
			$tpl->setVarBlock(strtoupper($this->type),"links", $link);
			return $tpl->parseBlock(strtoupper($this->type));
		}return "";
	}
	protected function paginationHtml($tpl){
		
		$pagina = $this->getPage();
		$total =  $this->getTotalPages();
		$paginas = $this->paginationPages;
		$separator = $tpl->parseBlock("SEPARATOR");
		$link = $separator;
		$tpl->setVarBlock(strtoupper($this->type),"pagina", $pagina);
		$tpl->setVarBlock(strtoupper($this->type),"total", $total);
		if ($this->getPrevLink()){
			$link .= $this->createlink($this->getFirstLink(),$tpl->parseBlock("INICIAL_".strtoupper($this->type)), $tpl, $this->controller).$separator;
			$link .= $this->createlink($this->getPrevLink(),$tpl->parseBlock("ANTERIOR_".strtoupper($this->type)), $tpl, $this->controller).$separator;
		}else{
			$link .= $this->createnolink($tpl->parseBlock("INICIAL_".strtoupper($this->type)), $tpl).$separator;
			$link .= $this->createnolink($tpl->parseBlock("ANTERIOR_".strtoupper($this->type)), $tpl).$separator;
		}
		$inferior = ($pagina -floor($paginas/2) < 1)?1:$pagina -floor($paginas/2);
		if($pagina +floor($paginas/2)+($paginas-$inferior) > $total){
			$superior = $total;
		}elseif($pagina==1){
			$superior = $paginas;
		}elseif($superior + $pagina +floor($paginas/2) > $total) {
			$superior = $total;
		}else{
			$superior = $pagina +round($paginas/2);
		}
		if($superior - $inferior > $paginas -1){
			$superior = $inferior + $paginas -1;
		}elseif($superior - $inferior < $paginas -1){
			$inferior = $superior - ($paginas -1);
		}
		$inferior = ($inferior < 1)?1:$inferior;
		Debug::add(__CLASS__.": Inicial = $inferior - Final = $superior");
		for($i=$inferior;$i<=$superior;$i++){
			if($i != $pagina){
				$link .= $this->createlink($this->getLink($i),$i,$tpl,$url).$separator;
			}else{
				$link .= $this->createnolink($i,$tpl,true).$separator;
			}
		}
		
		if ($this->getNextLink()){
			$link .= $this->createlink($this->getNextLink(),$tpl->parseBlock("SIGUIENTE_".strtoupper($this->type)), $tpl, $this->controller).$separator;
			$link .= $this->createlink($this->getLastLink(),$tpl->parseBlock("FINAL_".strtoupper($this->type)), $tpl, $this->controller).$separator;
		}else{
			$link .= $this->createnolink($tpl->parseBlock("SIGUIENTE_".strtoupper($this->type)), $tpl).$separator;
			$link .= $this->createnolink($tpl->parseBlock("FINAL_".strtoupper($this->type)), $tpl).$separator;
		}
		if($link != "" && (($this->max_pages == 0) || (($this->getPage()+1) <= $this->max_pages))){
			$tpl->setVarBlock(strtoupper($this->type),"links", $link);
			return $tpl->parseBlock(strtoupper($this->type));
		}return "";
	}
	
	public function getUpdateLink(){
		$tpl =  new Template("ajax_appender.tpl");
		
		$tpl->setVarBlock("LINK_UPDATE","url",$this->getFirstLink());
		$tpl->setVarBlock("LINK_UPDATE","function_prefix",$this->function_prefix);
		$tpl->setVarBlock("LINK_UPDATE","txt",$tpl->parseBlock("UPDATE"));
		$tpl->setVarBlock("LINK_UPDATE","txt_sanitized",$this->link);
		
		$this->link++;
		
		
		return $tpl->parseBlock("LINK_UPDATE");
		
	}
	
	public function getFirstLink(){
		return URL::getActualUrl()."?".$this->varName."=1".$this->params;
		
	}
	
	protected function createlink($url, $name,$tpl, $controller){
		$tpl->setVarBlock("LINK_".strtoupper($this->type), "url", $url);
		$tpl->setVarBlock("LINK_".strtoupper($this->type),"function_prefix",$this->function_prefix);
		$tpl->setVarBlock("LINK_".strtoupper($this->type), "txt", $name);
		$tpl->setVarBlock("LINK_".strtoupper($this->type),"txt_sanitized",$this->link);
		$tpl->setVarBlock("JS" ,"txt_sanitized",$this->link);
		$this->link++;
		//$tpl->setVarBlock("LINK_".strtoupper($this->type), "controller", $controller);

		return $tpl->parseBlock("LINK_".strtoupper($this->type));
	}
	
	protected function createnolink($name,$tpl,$resaltar=false){
		if($resaltar){
			$tpl->setVarBlock("RESALTADO", "txt",$name);
			return $tpl->parseBlock("RESALTADO");	
		}else{
			$tpl->setVarBlock("NOLINK_".strtoupper($this->type), "txt", $name);
			return $tpl->parseBlock("NOLINK_".strtoupper($this->type));
		}
	}
	
	public function getLink($page){
		return URL::getActualUrl()."?".$this->varName."=".$page.$this->params;
	}

}
