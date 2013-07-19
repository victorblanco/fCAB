<?php
/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: Victor Blanco 
 *	Date: 04/10/2009
 *	Company:
 */

class UserControl extends Object {

	protected $user;
	protected $perfil;
	protected $isSerialize = true;
	public function  __construct($userOrm = null){
		if (! is_null($userOrm) ){
			$this->user  = $userOrm;
		}
	}

	public function can($permiso){
		return $permiso & $this->user->perfil;
	}

	public function login( $name , $password){
		$rs	= new UsuariosRS();
		$ds	= App::getDS("DEFAULT");
		$filter 				= HashTable();
		$filter->usuario 	= $name;
		$filter->password	= $password;
		$sql					= $rs->sql($filter );

		$resultado			= $ds->exec($sql);
		$row					= $ds->next($resultado);


		$this->user 		= usuarios::getDefautl();
		$this->user->hydrate($row );

		Session::set("_USER_", $this->user);
	}

	public function __set($key){
		return $this->user->$key;
	}

	static  function getUser(){
		$user = unserialize(Session::get("_USER_"));
		if (!is_null($user)){
			return new UserControl($user);
		}else{
			return false;
		}
	}
}
