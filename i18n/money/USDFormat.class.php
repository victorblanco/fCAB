<?php


class USDFormat extends MoneyFormat implements IFactory {

	protected $decimals = 2;

	protected $decSeparator = '.';

	protected $thdSeparator = ',';

	protected $currencySymbol = 'USD';

	protected $currencySymbolHtml = '$';

	protected $currencySymbolPos = self::CURRPOS_BEFORE;
	
	
	public static function getDefault(){
		static $i = null;
		if (is_null($i)) $i = new USDFormat();
		return $i;
	}

}