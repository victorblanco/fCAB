<?php

/**
*	@Description: Se encarga de registrar y dejar accesible de una forma comoda 
*					informacion de los usuarios, tales como su nombre, email, id etc.
*
*	@Implements: Implementa la interfaz IFactory, facilitando si creacion
*				 Usage: MyObject::getDefault() y obtendrï¿½amos una instancia de tipo MyObject
*
*	@Author: Víctor Blanco 
*
*
*
*
*/


class UsserData  extends Object implements IFactory{
	
	protected static $instance = null;
	protected $rs = null;
	
	public function __construct(){
		$this->rs = new Factory(RS);
	}
	
	public static function getDefault(){
		
		if(is_null(self::$instance))
			self::$instance = new UsserData();
		return self::$instance;	 
	}


	/**
	*	@Description: Propiedad para obtener el valor de los atributos
	*
	*/
	public function __get($name){
	
		if(!Session::isRegister("id"))
			throw new Exception("No tenemos el usuario en session");
			
		$ret = Session::get($name);

		if(is_null($ret) | empty($ret)) 
			throw new Exception("No tenemos el usuario en session");
		
		return $ret;
	}
	
	public function get($name){
		return $this->__get($name);
	}

	/**
	*	@Description: Comprueba si el usuario se encuentra logeado
	*
	*/
	public function isLogged(){
	
		if(!Session::isRegister("id")) return false;
		if(is_null(Session::get("id")))return false;
		
		return true;
	}
	
	
	/**
	*	@Description: Carga los valores dado un id Usuario
	*
	*/
	public function load($id){
		
		try {
			$usuario = usuarios::getDefault()->getByPk($id);
			
			if (is_null($usuario))  throw new Exception("No se ha localizado un objeto usuario con id='".$id."'");
			
			if (!Session::isRegister("id"))Session::register("id");
			if (!Session::isRegister("usuario"))Session::register("usuario");
			if (!Session::isRegister("perfil"))Session::register("perfil");
			
			Session::set("id",$usuario->id);
			Session::set("perfil",$usuario->perfil);
			Session::set("usuario",$usuario->usuario);
			Session::set("descripcion",$usuario->descripcion);
			try {
				$filters = new HashTable();
				$filters->estado = 1;
				$limit = new HashTable();
				$limit->inferior = 0;
				$limit->superior = 1;
			}catch(Exception $e) { Debug::add($e); }
		}catch(Exception $e){ Debug::add($e); }
		
	}



}

