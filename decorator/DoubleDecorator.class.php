<?php


class DoubleDecorator extends Decorator implements IDecorator{

	function decorate($value){
		return NumberFormat::getDefault()->number($value);

	}


}

?>
