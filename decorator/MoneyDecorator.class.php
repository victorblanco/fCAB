<?php


class MoneyDecorator extends Decorator implements IDecorator{

	function decorate	($value){
		return NumberFormat::getDefault()->money($value);

	}


}
