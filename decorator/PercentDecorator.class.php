<?php
class PercentDecorator extends Decorator implements IDecorator{

	function decorate($value){
		return NumberFormat::getDefault()->number($value)."%";

	}


}
