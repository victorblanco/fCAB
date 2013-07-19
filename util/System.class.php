<?

class System extends Object{

	protected $respuesta;
	
	
	function __construct(){

	}

	public static function getDefault(){
		static $i =null;
		if (is_null($i)){
			$i = new System();
		}
		return $i;
	}

	public function execute ($line){
		Debug::add("SYSTEM: Ejecutando: $line");
		exec ($line, $this->respuesta);
		return $this;

	}
	
	public function getArrayRespuesta(){
		return $this->respuesta;
	}
	
	public function getTxtRespuesta(){
		return implode("\n",$this->respuesta);
	}


}
