<?php
/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: Víctor Blanco
 *	Date: 10/02/2008
 *	Company:
 */



/**
 *	@Description: Esta clase se encarga de calcular la paginacion de una query,
 *	dicha cuery no debe tener clausula order by, asi como tapoco debe tener clasula
 *	limit.
 *
 *	IMPORTANT:
 *		Se debe instanciar el objeto y lugo se debe setear(si hace falta), los metodos
 *		setRegistroPoraPagina(), setOrder(), y luego para obtener el RS por referencia se
 *		debe llamar al metodo getRs();
 *		Concluido este punto podemos llamar al resto de los metodos publicos:
 *		getTotalRecord(),  getTotalPages(),  getNextLink() ...
 *
 */
class Paginator extends Object{

	/**
	 * @Description: Objeto DB
	 */
	protected $db				= null;

	/**
	 * @Description: String de sql
	 */
	protected  $sql 			= null;

	/**
	 * @Description: Count records
	 */
	protected  $sqlCount		= null;

	/**
	 * @Description:Registros por pagina
	 */
	protected  $regPorPagina	= null;

	/**
	 * @Description: Pagina actual
	 */
	protected  $page 			= 0;

	/**
	 * @Description: Total de registros
	 */
	protected  $totalRecors	= 0;

	/**
	 * @Description: Count records
	 */
	protected  $total_pages	= 0;

	/**
	 * @Description: Parametros para pasar por url
	 */
	protected $params 		= null;

	protected $varName 		= 'page';

	/**
	 * Donde empieza el el listado
	 * @var int
	 */

	protected $min_row		= 0;

	/**
	 *	@Constructor.
	 *	@Params:
	 *		$dbObject: objeto manejador de DataBase
	 *		$sql: String de sql (query)
	 *		$regPorPagina: integer, rtegistros porpagina
	 *		$params: HashTable tipo clave valor ej: array("queryStringParamName"=>"queryStringParamValue")
	 */
	function __construct(Db $dbObject, $sql, $regPorPagina, HashTable $params = null, $varName = 'page'){
		parent::__construct();
		$this->db			= &$dbObject;
		$this->sql 			= $sql;
		$this->sqlCount 	= $sql;
		$this->regPorPagina	= $regPorPagina;
		$this->varName 		= $varName;

		$query_vars = array();
		if(is_object($params)){

			foreach ($params as $name => $value){
				if($name == $this->varName) continue;
				$query_vars[] = $name .'='.urlencode($value);
			}

			if(!is_array($query_vars)) return null;

			$query = implode('&', $query_vars);
			$this->params = "&".$query;

		}

	}

	public function __destruct(){
		unset($this);
	}


	/**
	 * 	@Description: Setea el total de registros por pagina, por defecto
	 *	este atributo tiene el valor de 10
	 *	@Access: Public
	 */
	public function setRegistroPoraPagina($value){
		$this->regPorPagina	= $value;
		return $this;
	}

	/**
	 * 	@Description: Setea el orden para la clausula "order by"
	 *	@Access: Public
	 *	@Params: $params: Array tipo clave valor ej: array("ColumnName"=>"OrderType")
	 */
	public function setOrder($params){

		if(is_array($params)){
			foreach ($params as $name => $value) $order_vars[] = $name .' '.$value;
			$order = implode(', ', $order_vars);

		}
		$this->sql .= " ORDER BY $order ";
		return $this;
	}

	/**
	 * 	@Description: Retorna el total de registros para la consulta
	 *	@Access: Public
	 */
	public function getTotalRecord(){
		return $this->totalRecors;
	}

	public function setPage($value){
		if(is_null($value) || empty($value) || $value == 0)	$value = 1;
		$this->page = $value;
		return $this;
	}

	/**
	 * 	@Description: Retorna la pagina actual
	 *	@Access: Public
	 */
	public function getPage(){
		if(is_null($this->page) || empty($this->page)){

			$p = 0;
			$params = App::request();
			foreach ($params as $name => $value){
				if($name == $this->varName){
					$p = $value;
				}
			}
			if(is_null($p) || empty($p) || $p == 0)	$this->page = 1;
			else $this->page = (int)($p);
		}
		return $this->page;

	}

	/**
	 * 	@Description: Inicializa el calculo y retorna el rs
	 * 	con los registros correspondiente a la pagina actual
	 */
	public function exec(){
		$rs = $this->_calculatePagination();
		$this->_calculateLimitSql();
		return $this->db->exec($this->sql);
	}

	/**
	 *	@Description: Retorna el total de paginas para la consulta
	 *	@Access: Public
	 */
	public function getTotalPages(){
		return $this->total_pages;
	}

	public function getDesde(){
		return ($this->getPage()*$this->regPorPagina) -$this->regPorPagina +1;
	}

	public function getHasta(){
		return $this->getDesde() + $this->regPorPagina -1;
	}



	/**
	 *	@Description: Retorna proximo link y los parametros a propagar por url
	 *	@Access: Public
	 */
	public function getNextLink(){

		if($this->getTotalPages() > $this->getPage())
		return URL::getActualUrl()."?".$this->varName."=".(int)($this->getPage()+1).$this->params;
		else	return false;

	}

	public function getLink($page){
		return URL::getActualUrl()."?".$this->varName."=".$page.$this->params;
	}
	
	/**
	 *	@Description: Retorna anterior link y los parametros a propagar por url
	 *	@Access: Public
	 */
	public function getPrevLink(){
		if($this->getPage() > 1)
		return URL::getActualUrl()."?".$this->varName."=".(int)($this->getPage()-1).$this->params;
		else	return false;
	}

	/**
	 *	@Description: Retorna la ultima pagina link y los parametros a propagar por url
	 *	@Access: Public
	 */
	function getLastLink(){
		if($this->getPage() < $this->getTotalPages())
		return URL::getActualUrl()."?".$this->varName."=".$this->getTotalPages().$this->params;
		else return false;
	}

	/**
	 *	@Description: Retorna el primer link y los parametros a propagar por url
	 *	@Access: Public
	 */
	public function getFirstLink(){
		if($this->getPage() > 1)
		return URL::getActualUrl()."?".$this->varName."=1".$this->params;
		else	return false;
	}


	public function setMinRow( $min ){
		$this->min_row = $min;
		return $this;
	}

	/**
	 *	@Description: Retorna el registro inferior mostrado
	 *	@Access: Public
	 */
	public function getInferiorRow(){
		$ret = (int)(($this->getPage()-1) * $this->regPorPagina);

		if ($ret < $this->min_row){
			return $this->min_row;
		}else{
			return $ret;
		}
	}

	/**
	 *	@Description: Retorna el registro superior mostrado
	 *	@Access: Public
	 */
	public function getSuperiorRow(){
		return $this->regPorPagina;
	}


	/**
	 *	@Description: calculo de sql con los limites
	 *	@Access: private
	 */
	protected function _calculateLimitSql(){
		if (strpos(strtoupper($this->sql), "LIMIT") === false){
			$this->sql .=" LIMIT ".$this->getInferiorRow() . ", ".$this->getSuperiorRow();
		}
	}

	/**
	 *	@Description: inicia el calculo de paginacion
	 *	@Access: Private
	 */
	protected function _calculatePagination(){
		try{
			$rs = $this->db->exec($this->sqlCount);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}

		$this->totalRecors = $this->db->count();
		$this->total_pages = (int)ceil($this->totalRecors / $this->regPorPagina);
		return false;
	}

		/**
	 *	@Description: Dibuja la paginación utilizando el template pagination.tpl por defecto.
	 *	@Access: Private
	 */

	public function pagination($url){
		$tpl =  new Template("pagination.tpl");

		$pagina = $this->getPage();
		$total =  $this->getTotalPages();
		$paginas = 5; 
		$tpl->setVar("pagina", $pagina);
		$tpl->setVar("total", $total);
		$links = "";
		if ($this->getPrevLink()){
			$link .= $this->createlink($this->getFirstLink(),$tpl->parseBlock("INICIAL"), $tpl, $url);
			$link .= $this->createlink($this->getPrevLink(),$tpl->parseBlock("ANTERIOR"), $tpl, $url);
		}else{
			$link .= $this->createnolink($tpl->parseBlock("INICIAL"), $tpl);
			$link .= $this->createnolink($tpl->parseBlock("ANTERIOR"), $tpl);
		}
		
		$inferior = ($pagina -floor($paginas/2) < 1)?1:$pagina -floor($paginas/2);
		$superior = ($pagina +floor($paginas/2)+($paginas-$inferior) > $total)?$total:$pagina +floor($paginas/2);
		
		if($superior - $inferior > $paginas -1){
			$superior = $inferior + $paginas -1;
		}elseif($superior - $inferior < $paginas -1){
			$inferior = $superior - ($paginas -1);
		}
		$inferior = ($inferior < 1)?1:$inferior;
		for($i=$inferior;$i<=$superior;$i++){
			if($i != $pagina){
				$link .= $this->createlink($this->getLink($i),$i,$tpl,$url);
			}else{
				$link .= $i;
			}
		}
		
		if ($this->getNextLink()){
			$link .= $this->createlink($this->getNextLink(),$tpl->parseBlock("SIGUIENTE"), $tpl, $url);
			$link .= $this->createlink($this->getLastLink(),$tpl->parseBlock("FINAL"), $tpl, $url);
		}else{
			$link .= $this->createnolink($tpl->parseBlock("SIGUIENTE"), $tpl);
			$link .= $this->createnolink($tpl->parseBlock("FINAL"), $tpl);
		}
		$tpl->setVarBlock("LINK",$url);
		$tpl->setVar("links", $link);
		return $tpl->parse();
	}

	protected function createlink($url, $name,$tpl, $controller){
		$tpl->setVarBlock("LINK", "url", $url);
		$tpl->setVarBlock("LINK", "txt", $name);
		$tpl->setVarBlock("LINK", "controller", $controller);

		return $tpl->parseBlock("LINK");
	}
	
	protected function createnolink($name,$tpl,$resaltar=false){
		if($resaltar){
			$tpl->setVarBlock("RESALTADO", "txt",$name);
			return $tpl->parseBlock("RESALTADO");	
		}else{
			$tpl->setVarBlock("NOLINK", "txt", $name);
			return $tpl->parseBlock("NOLINK");
		}
	}

}
