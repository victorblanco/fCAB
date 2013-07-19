<?php

class MailReader extends Object{

	protected $urlServidor  = "{%s/pop3:110}%s";
	protected $servidor;	
	protected $usuario;
	protected $password;
	protected $bandeja		= "INBOX";
	protected $link;

	function __construct(){

	}
	
	public function setServidor($servidor){
		$this->servidor = $servidor;
		return $this;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
		return $this;
	}

	public function setPassword($password){
		$this->password = $password;
		return $this;
	}

	public function getInbox(){
		return imap_headers($this->link);
	}

	public function getMail($number){
		$mail 		  =  get_object_vars(imap_header($this->link,$number));
		$mail['body'] = imap_body($this->link,$number);
		return $mail;
	}

	private function getUrl(){
		return sprintf($this->urlServidor, $this->servidor, $this->bandeja);
	}

	public function connect(){
		$this->link = imap_open($this->getUrl(),$this->usuario,$this->password);		
		return $this;
	}

	public static function getDefault(){
		static $i =null;
		if (is_null($i)){
			$i = new MailReader();
		}
		return $i;
	}


}
