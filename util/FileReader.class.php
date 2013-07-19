<?
class FileReader extends Object {

	protected $file;
	protected $txt;

	public function __construct( $file ) {
		parent::__construct();
		$this->file = $file;
		$this->txt 	= file_get_contents($file);
	}
	
	public function __destruct(){
		unset($this);
	}

	public function getTxt(){
		return $this->txt; 
	}
}
