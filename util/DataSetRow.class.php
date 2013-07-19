<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
 * This class represents a single Row in a DataSet
 *
 * It's an iterable class (implements Iterator) to be used on foreach() loops
 *
 * @package php
 * @subpackage util
 */
class DataSetRow extends Object implements Iterator {

	/**
	 * Array of row data
	 */
	private $data = array();

	/**
	 * Iterator::rewind() method. Called once at the beginning of a foreach loop
	 *
	 * Resets the column index to 0
	 */
	public function rewind() {
		reset( $this->data );
	}
	
	public function __destruct(){
		unset($this);
	}
	
	/**
	 * Iterator::current() method. Called on a foreach() loop to fetch the value (as in $key => $value)
	 *
	 * @return mixed The value in the current column
	 */
	public function current() {
		return current( $this->data );
	}

	/**
	 * Iterator::key() method. Called on a foreach() loop to fetch the key (as in $key => $value)
	 * 
	 * @return int The current column index
	 */
	public function key() {
		return key( $this->data );
	}

	/**
	 * Iterator::valid() method. Called on every pass of a foreach() loop to check if the current iteration is valid.
	 * (If false, the loop is broken)
	 *
	 * @return boolean Wether there is a column value for the current index
	 */
	public function valid() {
		return key( $this->data );
	}

	/**
	 * Iterator::next() method. Called on every pass of a foreach() loop, at the end, to advance the cursor.
	 * Moves to the next column in the row
	 */
	public function next() {
		next( $this->data );
	}

	/**
	 * Gets the value for the field $field
	 *
	 * @param string $field
	 * @return mixed value
	 * @throws Exception If the field doesn't exist
	 */
	public function __get( $field ) {
		if ( !isset( $this->data[$field] ) ) {
			//throw new Exception( sprintf( 'ERROR: Invalid field name: "%s"', $field ) );
		}
		return @$this->data[$field];
	}

	/**
	 * Sets the value for the field $field
	 *
	 * @param string $field
	 * @param mixed $value
	 */
	public function __set( $field, $value ) {
		$this->data[$field] = $value;
	}

	public function set($data, $encodear = false){
		if(is_array($data)){
			foreach($data as $k => $v){
				if ($encodear && !is_array($v) ){
					$this->data[$k] =  utf8_decode($v);
				}else{
					$this->data[$k] =  $v;
				}
			}
			return $this;
		}
		return false;
	}

	public function get(){
		return $this->data;
	}

	/**
	 * Returns a string representation of this column
	 *
	 * @return string
	 */
	public function __toString() {
		$str = sprintf( "%s [ID #%s]\n", get_class( $this ),  $this->id() );
		$str.= sprintf( " * Cols: %d\n", sizeof( $this->data ) );
		foreach( $this->data as $field => $value ) {
			$str.= sprintf( " - %-20s -> %s\n", $field, $value );
		}
		return $str;

	}

}
?>
