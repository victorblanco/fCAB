<?php



class FACTORIE extends Object {

	public $path = null;
	
	protected $instance = array();
	
	public function __call( $class, $argument ) {
		if (is_null( @$this->instance[$class] ) ){
			try{
				$this->instance[$class] = new $class($argument);
			}catch(Exception $e){
				throw new Exception("Clase $class no encontrada o con errores : ".$e->getMessage()."");
			}
		}
		
		return $this->instance[$class];
	}
	public static function getDefault(){
		static $i = null;
		
		if( is_null($i) ){
			$i = new FACTORIE();
		}
		return $i;
	}
	
	public function clean( $class ){
		unset($this->instance[$class]);
	}
}


