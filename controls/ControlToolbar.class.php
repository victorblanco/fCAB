<?


class ControlToolbar extends Control{
	protected $buttonSecundary;	
	protected $buttonPrimary;	
	protected $Buttons;
	protected $preload;

	public function __construct(){
		try{
		parent::__construct();
		$this->buttonSecundary = array();
		$this->buttonPrimary = array();
		$this->buttons = new ControlButton();
		
		$this->setTpl("ControlBarra.tpl");
		}catch(Exception $e){
			var_dump ($e);
		}
		
		
	}

	public function addButtonPrimary($name, $img, $action ,$alt, $cargando = 0){
		
		$this->buttonPrimary[] = $this->buttons->addButton($name, $img, $action ,$alt, $cargando)->parse();
		return $this;
	}
	public function addButtonSecundary($name, $img, $action ,$alt, $cargando = 0){
		$this->buttonSecundary[] = $this->buttons->addButton($name, $img, $action ,$alt, $cargando)->parse();
		return $this;
	}
	public function parse(){
		$bp = "";
		$bs = "";
		$this->preload = $this->buttons->getPreloadImg();
		
		if ($this->buttonPrimary) foreach ($this->buttonPrimary as $bbp){
			$bp .= $bbp;	
		}
		if ($this->buttonSecundary) foreach ($this->buttonSecundary as $bbs){
			$bs .= $bbs;	
		}
		$this->tpl->setVar("primary",$bp);
		$this->tpl->setVar("secundary",$bs);
		if (View::isPDF() || View::isXLS()){
			return "";
		}else{
			return $this->tpl->parse();	
		}		
	}
	
	public function getPreloadImg(){
		return $this->preload;
	}

	public function getDefault(){


	}
}


?>
