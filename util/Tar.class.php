<?

class Tar extends Object{
	protected $ruta;

	function __construct($ruta){
		$this->ruta = $ruta;
	}

	function getElements(){
		System::getDefault()->execute("tar tvf ".$this->ruta);
		return  System::getDefault()->getArrayRespuesta();
	}
}
