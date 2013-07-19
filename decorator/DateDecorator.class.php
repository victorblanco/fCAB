<?php
/*
 * Created on 25/03/2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class DateDecorator extends Decorator implements IDecorator{
	protected $formato;
 	
 	public function __construct( $params ){
 		if(isset($params[0])){list($this->formato) = $params[0];}
 		else{$this->formato = null;}
 	}
 	public function  decorate($value){
		if(is_null($this->formato)){ return Date::parse($value)->format(DateFormat::DATE_FORMAT_DEFAULT);}
		else{ return Date::parse($value)->format($this->formato);}
	 }


}