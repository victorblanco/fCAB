<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class DirIterator extends Object implements Iterator {
    
    protected $dir;
	
    protected $key;
	
    protected $file;
	
    protected $valid;
    
	protected $path;
	    
    public function __construct($path = "./"){
		parent::__construct();
		$this->dir = @opendir($path);
		$this->path = $path;
    }
    
    public function __destruct() {

		if(is_resource($this->dir))      closedir($this->dir);
		unset($this); 
    }
    
    public function rewind() {
        $this->key = 0;
        rewinddir($this->dir);
        $this->next();
    }
    
    public function next() {
        $this->key++;
        $this->valid();
    }
    
    public function key() {
        return $this->key;
    }
    
    public function current() {
        return $this->file;
    }
    
    public function valid() {
		if(!is_resource($this->dir)) return false;
		
		$this->valid = false !== ($this->file = readdir($this->dir));
        return $this->valid;
    }
	
	public function isDir(){
		return is_dir($this->path."/".$this->current());
	}
	
	public function getIterator(){
		if($this->isDir() === true){
			return new DirIterator($this->current());
		}else{
			return new DirIterator($this->path);
		}
	}
	
	public function create($path,$subdir){
		return mkdir($path.$subdir);
	}


}

/* Usage: 
$dir = new DirIterator(’/tmp’);
foreach ( $dir as $file ) {
	// Do something with file
*/


?>
