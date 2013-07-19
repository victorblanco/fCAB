<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

/**
* Basic HashTable class, wrapping around a standard associative array.
*
*/
class HashTable extends Object implements Iterator{
	
	/**
	 * The underlying array.
	 */
	private $array = array();

	public $has;

	public function __construct( $values=null ) {
		
		//$this->has = new HashTable();
		
		parent::__construct();
		if ( is_array( $values ) ) {
			$this->array = $values;
		}else{
			$temp = func_get_args();
			if(!is_null($temp) && is_array($temp))
				$this->array = $temp;
		}
	}
	
	public function __destruct(){
		unset($this);
	}
	
	/**
	 * Puts a new value into the Hashtable
	 *
	 * @param string $key
	 * @param mixed $val
	 */
	public function put( $key, $val ) {
		$this->array[$key] = $val;
		return $this;
	}
	
	/**
	 * Checks wether a given key exists in the Hashtable.
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function has( $key ) {
		return array_key_exists( $key, $this->array );
	}
	
	/**
	 * Gets a value from the Hashtable.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get( $key ) {
		return ( $this->has($key) ? $this->array[$key] : null );
	}

	/**
	 * Magic Getter. Wraps get
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->get( $key );
	}

	/**
	 * Magic Setter. Wraps put
	 *
	 * @param string $key
	 * @param mixed $val
	 */ 
	public function __set( $key, $val ) {
		$this->put( $key, $val );
	}
	
	/**
	 * Returns the underlying associative array.
	 *
	 * @return array
	 */
	public function toArray() {
		return $this->array;
	}
	
	/**
	 * Clears the Hashtable, emptying the underlying array.
	 */
	public function clear() {
		$this->array = array();
	}

	/**
	 * Returns the size of this Hashtable (amount of elements)
	 * 
	 * @return int
	 */
	public function length() {
		return sizeof( $this->array );
	}

	/**
	 * Return the keys for this Hashtable
	 *
	 * @return array
	 */
	public function getKeys() {
		return array_keys( $this->array );
	}

		
	public function rewind() {
		reset($this->array);
	}
	
	public function count() {
		return count($this->array);
	}
	
	public function current() {
		$element = current($this->array);
		return $element;
	}
	
	public function next() {
		$element = next($this->array);
		return $element;
	}
	
	public function key() {
		$element = key($this->array);
		return $element;
	}
	
	public function valid() {
		return ($this->current() !== false);
	}

	/**
	 * Returns a string representation of this Hashtable.
	 */
	public function __toString() {
		$str = sprintf( "[Hashtable (ID #%s)] (%d elements)\n", $this->id(), $this->length() );
		$str.= "Values:\n";
		foreach( $this->array as $field => $value ) {
			$str.= sprintf( "  -> %-25s = %s\n", $field, $value );
		}
		return $str."\n";
	}
	

}


