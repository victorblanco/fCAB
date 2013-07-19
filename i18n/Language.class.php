<?php


class Language extends LanguageFactory {

	/**
	 * Default Number Format Instance
	 */
	protected static $default = null;

	/**
	 * Array of language names
	 */
	protected $names = array();

	/**
	 * Returns a language name
	 *
	 * @param string $language
	 * @return string
	 */
	public function name( $language ) {
		if ( !isset( $this->names[$language] ) ) {
			throw new Exception( sprintf( 'No name defined for Language "%s" on this locale', $language ) );
		}
		return $this->names[$language];
	}
}
