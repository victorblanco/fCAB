<?php	

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

abstract class Output extends Object{
	
		
	 public function __construct()  {
	 	parent::__construct();
	 }


	/**
	* Método estático que retorna el nombre de la clase.
	*
	* @access public
	* @return string Nombre de la clase.
	*/
    public function getClassName()  {
        return "Output";
    }
	
	public function __destruct(){
		unset($this);
	}

	abstract public function getOutput();
	
	
	public function getKey(){}
}

?>