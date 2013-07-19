<?php 
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Xml extends Object {
	
	protected $file 	= null;
	
	protected $handler 	= null;
	

	public function __construct($filePath){
		parent::__construct();
		
		$this->file = new FileWriter($filePath);
		
		if(!$this->file->isReadable())
                    if (!simplexml_load_string($filePath))
			throw new Exception("ERROR: No es posible leer el fichero: $filePath");
                    else
                         $this->handler = simplexml_load_string($filePath);
                else
                    $this->handler = simplexml_load_file($filePath);
	}
	
	public function __destruct(){
		unset($this);
	}

	/**
	*	@Description: Retorna un iterador para leerlo
	*	desde un foreach
	*
	*/
	public function getIterator(){
		return $this->handler;
	}
	
	public function setIterator($iterator){
		$this->handler = $iterator;
		return $this;
		
	}
	/**
	*	@Description: Guard el xml en el fichero que lectura, si le pasamos
	*		por parametro otro fichero lo guardara en el.
	*	
	*/
	public function save($filepath = null){
		if(!is_null($filepath))	$this->file = new FileWriter($filepath);
		
		return $this->file->write($this->handler->asXML(),"w+");
	}
	
	/**
	*	@Crea un elemento y retorna la referencia al nuevo elemento
	*		Lo debemos tratar a cada elemento como un objeto	
	*	
	*/
	public function addElement(SimpleXMLElement $element, $name){
		return $element->addChild($name);
	}
}



/*
<code>
	try {
	
		$xml = new Xml("rss.xml");
		
		$i = $xml->getIterator();
		# read xml file
		foreach($i->channel as $item){
			var_dump($item->title);
		}
		
		# write xml doument
		$n = $xml->addElement($i->channel,"item");
		$n->title 		= "titulo";
		$n->link 		= "un enlace";
		$n->description = "nua descripcion";
		
		$xml->save();
		
	}catch(Exception $e){
	
	}
	
	

</code>
*/


