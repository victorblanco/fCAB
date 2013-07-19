<?php


abstract class I18N extends Object implements Iterator {
	
	protected $table;
	protected $value;
	protected $key;
	protected $className;
	
	protected $DS;
	
	protected $data = array();
	
	public function __construct(){
		$this->parseRs();
	}
	
	protected function parseRs(){
		list($ds, $rs) = FACTORIE::getDefault()->I18NRS()->sql( $this->table, $this->key, $this->value , $this->DS);
		
		while( $fila = $ds->next($rs)){
			$key	= $this->key;
			$value 	= $this->value;
			$this->data[$fila->$key] = $fila->$value;
		}
	}
	
	public function __get( $name ){
		
		return $this->data[$name];
	}
	
	public function getKeyByValue( $value ){
		return array_search( $value , $this->data );
	}
	
	public function getTranslator( $value ){
		$key = $this->className."-".$value; 
		return App::getTranslator("_i18n")->$key;
	}
	
  	public function rewind() {
        reset( $this->data);
    }
   
    public function current() {
        return current( $this->data);
    }
   
    public function key() {
        return key( $this->data);
    }
   
    public function valid() {
        return key( $this->data);
    }
   
    public function next() {
        next( $this->data);
    }
   
    public function count() {
        return count($this->data);
    }
	
 
}

