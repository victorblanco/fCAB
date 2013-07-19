<?php

class Calculator extends Object{
	const PORCENTAJE_ANADE				= 0;
	const PORCENTAJE_DESCUENTO			= 1;
	const PORCENTAJE_VALOR_DESCUENTO	= 2;

	/**
	*Calculo del descuento
	* type = 0 añade
	* type = 1 descuenta
	* type = 2 descuento 
	*
	*/
	static function Porcentaje($price, $discount, $type){
		switch ($type){
			case 0:	
				return $price * (1 + ($discount / 100));
			break;
			case 1:
				return $price * (1 - ($discount / 100));	
			break;
			case 2:
				return $price * (($discount / 100));
			break;
		}
	}
}
