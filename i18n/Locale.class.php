<?php


/**
 * Base Locale Class, providing all the static methods for Localized/Internationalized information manipulation.
 * 
 * This Class acts as a static Proxy to one of the php::i18n::locales::* classes.
 */
class Locale extends Object implements Iterator {
	
	
	/**
	 * The Locale in use
	 */
	private static $defaultLocale = null;

	/**
	 * Locale name (ie: 'es_ES', 'en_GB')
	 */
	protected $locale = null;

	/**
	 * Locale language (ie: 'es', 'en')
	 */
	protected $language = null;

	/**
	 * Locale Country (ie: 'ES', 'GB')
	 */
	protected $country = null;

	/**
	 * Locale Display Name (ie: 'Espanol (Espana)', 'English (GB)')
	 */
	protected $name = null;
	
	/**
	 * 
	 * Locale $data array para que sea iterable.
	 */
	protected $data = array();

	/**
	 * Instantiates a new Locale Class for the given locale ( language_COUNTRY )
	 *
	 * @param string $locale
	 */
	public function __construct( $locale ) {
		$sp = explode( '_', $locale );
		if(count($sp) == 1)	$sp = explode( '-', $locale );
		
		$this->language = $sp[0];
		$this->country = $sp[1];
		$this->locale = $sp[0]."_".$sp[1];
		
		
		
		switch ($this->language) {
		    case 'es': $this->languageId = 1; break;
		    case 'ct': $this->languageId = 2; break;
		    case 'en': $this->languageId = 3; break;
		    case 'ru': $this->languageId = 4; break;
		    case 'pt': $this->languageId = 5; break;
		    case 'gl': $this->languageId = 6; break;
		    case 'eu': $this->languageId = 7; break;
		}
		
	}
	/**
	 * Metodos iterables
	 * 
	 * 
	 */
	
	public function count() {
		return count($this->data);
	}
	
	public function current() {
		$element = current($this->data);
		return $element;
	}
	
	public function next() {
		$element = next($this->data);
		return $element;
	}
	
	public function key() {
		$element = key($this->data);
		return $element;
	}
	
	public function rewind() {
		reset($this->data);
	}
	
	
	public function valid() {
		return ($this->current() !== false);
	}
	
	public function getTrads( $id  ){
		return $this->data[$id];
	}

	/**
	 * Sets the default Locale
	 *
	 * @param string $locale
	 */
	public static function setDefault( $locale ) {
		self::$defaultLocale = new Locale( $locale );
	}

	/**
	 * Gets the Default Locale
	 *
	 * @return Locale
	 */
	public static function getDefault() {
		if ( !self::$defaultLocale ) {
			throw new Exception( 'No default Locale Available. Use setDefault() first?' );
		}
		return self::$defaultLocale;
	}

	/**
	 * Returns the Locale ID string (language_COUNTRY)
	 *
	 * @return string
	 */
	public function getLocale() {
		return $this->locale;
	}

	/**
	 * Returns the Locale Name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Gets the Locale language
	 *
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * Gets the Language name for this locale
	 *
	 * @return string
	 */
	public function getLanguageName() {
		return Language::getDefault()->name( $this->language );
	}

	/**
	 * Gets the Locale Country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Returns the current language id
	 *
	 * @return int
	 */
	public function getLanguageId() {
	    return $this->languageId;
	}
	/**
	 * Returns a string representation of this locale
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getLocale();
	}
	
	public function __toArray(){
		return $this->data;
	}
}
