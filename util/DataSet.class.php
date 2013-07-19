<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class DataSet extends Object implements Iterator, ArrayAccess {

	/**
	 * Array of column names
	 */
	private $cols = array();

	/**
	 * Array of DataSetRows
	 */ 
	private $rows = array();

	/**
	 * Iterator::rewind() method. Called once at the beginning of a foreach loop
	 *
	 * Resets the current row index to 0
	 */
	public function rewind() {
		$this->index = 0;
	}
	
	public function __destruct(){
		unset($this);
	}
	
	/**
	 * Iterator::current() method. Called on a foreach() loop to fetch the value (as in $key => $value)
	 *
	 * @return DataSetRow The current DataSetRow
	 */
	public function current() {
		return $this->rows[$this->index];
	}

	/**
	 * Iterator::key() method. Called on a foreach() loop to fetch the key (as in $key => $value)
	 * 
	 * @return int The current row index
	 */
	public function key() {
		return $this->index;
	}

	/**
	 * Iterator::valid() method. Called on every pass of a foreach() loop to check if the current iteration is valid.
	 * (If false, the loop is broken)
	 *
	 * @return boolean Wether there is a current row
	 */
	public function valid() {
		return isset( $this->rows[$this->index] );
	}

	/**
	 * Iterator::next() method. Called on every pass of a foreach() loop, at the end, to advance the cursor.
	 * Moves to the next row in the result set, subsequently calling loadRow()
	 *
	 * @return boolean The next DataSetRow
	 */
	public function next() {
		$this->index++;
	}

	/**
	 * ArrayAccess::offsetExists() method. 
	 *
	 * @param int $offset 
	 * @return boolean Wether the given offset exists (there's a row with that index)
	 */
	public function offsetExists( $offset ) {
		return isset( $this->rows[$offset] );
	}

	/**
	 * ArrayAccess::offsetGet method.
	 *
	 * @param int $offset 
	 * @return DataSetRow Returns the DataSetRow in offset $offset
	 * @throws Exception If there's not row for that offset
	 */
	public function offsetGet( $offset ) {
		if ( !isset( $this->rows[$offset] ) ) {
			throw new Exception( sprintf( 'No Row with index: %d', $offset ) );
		}
		return $this->rows[$offset];
	}

	/**
	 * ArrayAccess::offsetSet method.
	 *
	 * Sets the DataSetRow in index $offset
	 *
	 * @param int $offset 
	 * @param DataSetRow $row
	 * @throws Exception If row is not a DataSetRow
	 */
	public function offsetSet( $offset, $row ) {
		if ( !is_object( $row ) && !$row instanceOf DataSetRow ) {
			throw new Exception( 'ERROR: Row must be an Object of type DataSetRow' );
		}
		$this->rows[$offset] = $row;
	}

	/**
	 * ArrayAccess::offsetUnset method.
	 *
	 * Removes the DataSetRow at offset $offset. Note that the row numbers are recalculated
	 * (empty rows aren't supported)
	 *
	 * @param int $offset
	 */
	public function offsetUnset( $offset ) {
		unset( $this->rows[$offset] );
	}

	/**
	 * Adds a Column to this DataSet
	 *
	 * @param string $col Column name
	 */
	public function addCol( $col ) {
		$this->cols[] = $col;
	}

	/**
	 * Sets the columns on this DataSet
	 *
	 * @param array $cols
	 */
	public function setCols( array $cols ) {
		$this->cols = $cols;
	}

	public function getCols() {
		return $this->cols;
	}

	/**
	 * Adds a Row to this DataSet.
	 * The arguments are mapped to each defined column, and the amount of values must match the amount of columns
	 *
	 * @param * 
	 * @throws Exception If the are less or more values than columns
	 */
	public function addRow() {
		$values = func_get_args();
		if ( is_array( $values[0] ) ) {
			$values = $values[0];
		}
		if ( sizeof( $values ) != sizeof( $this->cols ) ) {
			throw new Exception( sprintf( 'ERROR: Invalid amount of values for Row. Defined Columns: %d, Provided Values: %d', sizeof( $values ), sizeof( $this->cols ) ) );
		}
		$row = new DataSetRow();
		foreach( $this->cols as $i => $col ) {
			$row->$col = $values[$i];
		}
		$this->rows[] = $row;
	}

	/**
	 * Returns a string representation of this DataSet
	 *
	 * @return string
	 */
	public function __toString() {
		$str = sprintf( "%s [ID #%s]\n", get_class( $this ),  $this->id() );
		$str.= sprintf( " * Rows: %d\n", sizeof( $this->rows ) );
		foreach( $this->rows as $i => $row ) {
			$str.= sprintf( " # Row: %d\n", $i );
			foreach( $row as $field => $value ) {
				$str.= sprintf( "  : %-20s -> %s\n", $field, $value );
			}
		}
		return $str;

	}
}

?>
