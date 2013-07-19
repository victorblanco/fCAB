<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class File extends Object{
    
    protected $handle;
	
    protected $file;
	
    protected $mode;
    
	    
    public function __construct($file){
		parent::__construct();
		$this->file = $file;
    }
    
    public function __destruct() {
		unset($this);
	}
	
	
	public function __set($attribute,$value){
		$this->$attribute = value;
	}
	
	public function __get($attribute){
		return $this->$attribute;
	}
    
    public function isReadable($file = null) {
		if(is_null($file))
			return is_readable($this->file);
		return is_readable($file);
    }
    
    public function isWritable($file = null) {
		if(is_null($file))
			return is_writable($this->file);
		return is_writable($file);
	}
	
	public function open($mode = 'r'){
	
		$this->handle  = fopen($this->file, $mode);
		
		if(!is_resource($this->handle))
			throw new Exception("ERROR: No se ha podido abrir el fichero ".$this->file);
		return $this;
	}
    
	public function close(){
		@fclose($this->handle);
	}
    
	public function getReaderIterator(){
		return new FileReaderIterator($this);
	}
	
	public function getWriter(){
		return new FileWriter($this->file);
	}
	
	
	public function write($content){
		$ret = fwrite($this->handle,$content);
		$this->close();
		
		if($ret === true) return true;
		return false;
	}
	
	public function isFile(){
		return is_file($this->file);
	}
	
	
	public function getContent(){
		return file_get_contents($this->file);
	}
	
	public function delete(){
		return unlink($this->file);
	}
	
	public function fileTime(){
		return filemtime($this->file);
	}
	public function chmod($value){
		chmod($this->file);
		return $this;
	}
	
	
}

/* Usage: 
$dir = new DirIterator(’/tmp’);
foreach ( $dir as $file ) {
	// Do something with file
*/


