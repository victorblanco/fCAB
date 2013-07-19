<?php



class MoneyFormat {

/**
	 * Constant for Currency Symbol Position Before Number
	 */
	const CURRPOS_BEFORE = 0;

	/**
	 * Constant for Currency Symbol Position After Number
	 */
	const CURRPOS_AFTER = 1;

	/**
	 * Default Number Format Instance
	 */
	protected static $default = null;

	/**
	 * Number of decimals
 	 */
	protected $decimals = 0;

	/**
	 * Decimals Separator
	 */
	protected $decSeparator = '';

	/**
	 * Thounsands Separator
	 */
	protected $thdSeparator = '';

	/**
	 * Currency Symbol
	 */
	protected $currencySymbol = '';

	/**
	 * Currency HTML Symbol
	 */
	protected $currencySymbolHtml = '';

	/**
	 * Currency Symbol Position
	 */
	protected $currencySymbolPos = self::CURRPOS_AFTER;

	/**
 	 * Formats a number
	 *
	 * @param string $number
	 * @return string
	 */
	public function number( $number ) {
		return number_format( $number, $this->decimals, $this->decSeparator, $this->thdSeparator );
	}

	/**
	 * Formats a currency value
	 *
	 * @param string $number
	 * @return string
	 */
	public function money( $number ) {
		$n = $this->number( $number );
		switch( $this->currencySymbolPos ) {
			case self::CURRPOS_BEFORE: return $this->currencySymbolHtml.' '.$n;
			case self::CURRPOS_AFTER : return $n.' '.$this->currencySymbolHtml;
			default: return $n;
		}
	}

}