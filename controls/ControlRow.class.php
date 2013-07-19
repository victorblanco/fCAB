<?
class ControlRow extends Control implements IFactory{
	
	protected $buttons;
	protected $tds;
	protected $trAction;
	protected $trClass		 = "";
	protected $tdClass		 = "odd";
	protected $tdExtra;
	protected $rightAction	 = "";	
	protected $leftAction 	 = "";
	protected $rel;

	public function __construct(){
		try{
		parent::__construct();
		$this->buttons = new ControlButton();
	  	$this->setTpl("ControlRow.tpl");
		$this->clearObject();
		}catch(Exception $e){
			Debug::add($e);
		}
		
		
	}

	protected function clearObject(){
		$this->trAction	= "";
		$this->trClass 	= "";
		$this->tdExtra	= array();
		$this->tdClass  = "";
		$this->tds 	= "";
		$this->rightAction= "&nbsp;";
		$this->leftAction = "&nbsp;";
	}
	
	public function setTrClass($c){
		$this->trClass = $c;
		return $this;
	}
	
	public function setRel($c){
		$this->rel = $c;
		return $this;
	}
	
	
	public function getRel(){
		return $this->rel; 
		
	}
	
	
	public function setTdClass($c){
		$this->tdClass = $c;
		return $this;
	}
	
	public function setTdExtra($ex){
		$this->tdExtra = $ex;
		return $this;
	}

	public function setTrAction($tra){
		$this->trAction = $tra;
		return $this;
	}
	
	public function setLeftAction($la){
		$this->leftAction = $la;
		return $this;
	}
	
	public function setRightAction($ra){
		$this->rightAction = $ra;
		return $this;
	}

	public function addRow($row){
		$this->tds  = "";
		$this->tds .= $this->borderRow($this->leftAction);	
		$i =0;
		foreach ($row as $r){
			$this->tpl->setVarBlock("td","content",$r);
			$this->tpl->setVarBlock("td","td_class",$this->tdClass);
			if (is_array($this->tdExtra)){
					$this->tpl->setVarBlock("td","td_extras", $this->tdExtra[$i]);
					$i++;
			}else{
				$this->tpl->setVarBlock("td","td_extras","");
			}
			$this->tds .= $this->tpl->parseBlock("td");
		}
		$this->tds .= $this->borderRow($this->rightAction);	
		return $this;
	}
	
	protected function borderRow ($action){
		$this->tpl->setVarBlock("td","td_extras"," style='width: 18px;' ");
		$this->tpl->setVarBlock("td","td_class","indice");
		$this->tpl->setVarBlock("td","content",$action);
		return $this->tpl->parseBlock("td");
	}
	

	public function parse(){
		//if ($this->trClass)
		//	$this->tpl->setVar("mouseover",$this->tpl->parseBlock("mouse_over"));
		$this->tpl->setVar("tr_class", $this->trClass);
		$this->tpl->setVar("tr_action",$this->trAction);
		$this->tpl->setVar("rel", $this->getRel());
		$this->tpl->setVar("tds",$this->tds);
		$this->clearObject();
		return $this->tpl->parse();
	}
	
	static function getDefault(){
		static $i = null;
		if(is_null($i)) $i = new ControlRow();
		return $i;
	}
}


?>
