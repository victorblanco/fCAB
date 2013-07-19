<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/



class FileWriter extends File{
    
    public function __construct($file){
		parent::__construct($file);
    }
    
    public function __destruct() {
		$this->close();
		unset($this);
	}
	
	
	public function open($mode = 'w'){
	
		$this->handle  = fopen($this->file, $mode);
		
		if(!is_resource($this->handle))
			throw new Exception("ERROR: No se ha podido abrir el fichero ".$this->file);
		return $this;
	}
    
	
	public function write($content,$mode = 'a+'){
		
		$this->open($mode);
		
		$ret = fwrite($this->handle,$content);
		
		$this->close();
		
		if($ret === true) return true;
		
		return false;
	}
}

