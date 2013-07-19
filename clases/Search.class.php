<?php 

class Search extends Output{
	
	protected $rs;
	protected $headers;
	protected $fields;
	protected $fields_return;
	protected $type;
	protected $headers_;
	protected $fields_="";
	protected $rs_ ="";
	protected $resul; 
	protected $form;
	protected $rel;
	protected $trAction;
	protected $tdExtra;
	protected $tdExtraHeader;
	protected $trActionParams;
	protected $leftAction;
	protected $leftActionParams;
	protected $rightAction;
	protected $setInput = true;
	protected $rightActionParams;

	function __construct() {
		parent::__construct();
	}
	
	public function setRS ($r, $resultado = null){
		$this->rs = $r;
		$this->resul = $resultado;
		return $this;		
	}
	
	public function setTrAction($tra, $params){
		$this->trAction = $tra;
		$this->trActionParams = $params;
	}

	public function setRightAction($ra, $params){
		$this->rightAction = $ra;
		$this->rightActionParams = $params;
	}

	public function setFields($f){
		$this->fields = $f;
		return $this;
	}
	
	public function setHeaders($h){
		$this->headers = $h;
		return $this;
	}
	
	public function setFieldsReturn($fr){
		$this->fields_return = $fr;
		return $this;
	}
	
	public function setTdExtra($ex){
		$this->tdExtra = $ex;
		return $this;
	}
	
	public function setTdExtraHeader($ex){
		$this->tdExtraHeader = $ex;
		return $this;
	}
	
	public function setType ($t){
		$this->type = $t;
		return $this;
	}
	public function setInput($i){
		$this->setInput = $i;
		return $this;
	}
	
	protected function parseHeaders(){
		$this->headers_ = ControlRow::getDefault()
								->setTdExtra($this->tdExtraHeader)
								->setTrClass("indice")
								->setTdClass("indice")->addRow($this->headers)->parse();
	}
	
	public function setForm($form){
		$this->form = $form;
	}
	
	protected function parseFields(){
		$f = array();
			
		foreach ($this->fields as $field){
			$f[] = ControlInput::getDefault()->setName($field)->setType("text")->setValue(Http::r()->$field)->parse();
		}
		$this->fields_ = $this->form->setCONTENT(ControlRow::getDefault()->setTdExtra($this->tdExtra)->setTrClass("odd")->addRow($f)->parse())->parse();
		
	}
	
	protected function parseRS(){
		
		if (gettype($this->rs) == "object"){	
			while ($fila = $this->rs->next($this->resul)){
				$f = $fila->get();
				if (!is_null($this->trAction))
					ControlRow::getDefault()->setTrAction(vsprintf($this->trAction, $this->getParams($f,$this->trActionParams)));

				if (!is_null($this->rightAction)){
					$action = vsprintf($this->rightAction, $this->getParams($f,$this->rightActionParams));
					ControlRow::getDefault()->setRightAction($action);
				}
				$this->rs_ .= ControlRow::getDefault()->setTdExtra($this->tdExtra)->setTrClass("odd")->addRow($this->getParams($f,$this->fields))->parse();		
			}
		}else{
			foreach ($this->rs as $f){
				if (!is_null($this->trAction))
					ControlRow::getDefault()->setTrAction(vsprintf($this->trAction, $this->getParams($f, $this->trActionParams)));

				if (!is_null($this->rightAction)){
 					$action = vsprintf($this->rightAction, $this->getParams($f,$this->rightActionParams));
					ControlRow::getDefault()->setRightAction($action);
				}
				if (!is_null($this->rs))
					if (is_array($f)){
						$rows =  $this->getParams($f, $this->fields);
					}else{
						$rows = array($f);
					}
					$this->rs_ .= ControlRow::getDefault()->setTdExtra($this->tdExtra)->setTrClass("odd")->addRow( $rows)->parse();	
				;
		}
	}
	}
	
	protected function getParams($fields, $params) {
		$Params_ = array();
		if ($params){
			foreach ($params as $p){
		     		$Params_[] = $fields[$p];
	
			}
		}else{
			$cuenta = count($fields);
			for ($i=0; $i <= $cuenta ; $i++ ){
				$Params_[] = $fields[$i];
			}
		}
		return $Params_;
	}
	
	public function getOutput(){
		try{
		if ($this->headers)
			$this->parseHeaders();
		if ($this->fields && $this->setInput){	
			$this->parseFields();
		}
		if ($this->rs){
			$this->parseRS();
		}else{
			$this->rs_= "<center>No results</centre>";
// 			throw new Exception("No estan seteado rs y/o fields");
		}
		
		$tpl = new Template("search.tpl", tpl_dir, tpl_pre);
		$tpl->setVar("CONTENT",$this->headers_.$this->fields_.$this->rs_);
		
		return $tpl->parse();
		}catch(Exception $e){
			Debug::add($e);

		}
	}
}
