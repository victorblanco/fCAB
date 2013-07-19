<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class FileReaderIterator extends Object implements Iterator {

	/**
	 * File Object
	 */
	protected $file = null;

	/**
	 * Current line in file
	 */
	protected $line = null;

	/**
	 * Current line number
	 */
	protected $linen = 0;

	/**
	 * Instantiates a new FileIterator for the given File
	 *
	 * @param File $file
	 */
	public function __construct( File $file ) {
		parent::__construct();
		$this->file = $file;
		$this->file->open();
	}
	
	public function __destruct(){
		$this->file->close();
		unset($this);
	}

	/**
	 * Returns the current line
	 *
	 * @return string
	 */
	public function current() {
		return $this->line;
	}

	/**
	 * Advances the pointer, returning the next line
	 *
	 * @return string
	 */ 
	public function next() {
		$this->linen++;
		return $this->line = fgets( $this->file->handle, 4096 );
	}

	/**
	 * Returns the current line number
	 *
	 * @return int
	 */
	public function key() {
		return $this->linen;
	}

	/**
	 * Wether the current line is not false.
	 * 
	 * @return boolean
	 */
	public function valid() {
		return $this->line !== false;
	}

	/**
	 * Rewinds the internal file pointer to the first line number
	 */
	public function rewind() {
		rewind( $this->fp );
		return $this->line = fgets($this->file->handle, 4096 );
	}

}

?>
