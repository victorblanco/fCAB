<?php


class GBPFormat extends MoneyFormat implements IFactory {

	protected $decimals = 2;

	protected $decSeparator = '.';

	protected $thdSeparator = ',';

	protected $currencySymbol = 'GBP';

	protected $currencySymbolHtml = '&#163;';

	protected $currencySymbolPos = self::CURRPOS_BEFORE;
	
	
	public static function getDefault(){
		static $i = null;
		if (is_null($i)) $i = new GBPFormat();
		return $i;
	}

}