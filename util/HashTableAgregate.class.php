<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class HashTableAgregate extends Object implements IteratorAggregate{

    private $items = array();
	
    private $count = 0;

	public function __construct(){
		parent::__construct();
	}
	
	public function __destruct(){
		unset($this);
	}
	
    public function getIterator() {
        return new HashTable($this->items);
    }

    public function add($value) {
        $this->items[$this->count++] = $value;
		return $this;
    }
	
}
/*
$coll = new HashTableAgregate();
$coll->add('value 1');
$coll->add('value 2');
$coll->add('value 3');

foreach ($coll as $key => $val) {
    echo "key/value: [$key -> $val]\n\n";
}
*/
?> 
