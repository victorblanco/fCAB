<?php


class EURFormat extends MoneyFormat implements IFactory {

	protected $decimals = 2;

	protected $decSeparator = ',';

	protected $thdSeparator = '.';

	protected $currencySymbol = 'EUR';

	protected $currencySymbolHtml = '&euro;';

	protected $currencySymbolPos = self::CURRPOS_AFTER;
	
	
	public static function getDefault(){
		static $i = null;
		if (is_null($i)) $i = new EURFormat();
		return $i;
	}

}