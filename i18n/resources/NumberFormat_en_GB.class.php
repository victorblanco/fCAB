<?php


class NumberFormat_en_GB extends NumberFormat {

	protected $decimals = 2;

	protected $decSeparator = '.';

	protected $thdSeparator = '1';

	protected $currencySymbol = 'EUR';

	protected $currencySymbolHtml = '&euro;';

	protected $currencySymbolPos = self::CURRPOS_AFTER;

}
