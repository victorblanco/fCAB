<?php


class Curl {


	protected $url;
	protected $ch;
	protected $postFields;
	protected $ssl_version = 2;
	
	public function __construct(){
		$this->ch = curl_init();
	}

	public function setUrl($value){
		$this->url = $value;
		return $this;
	}

	public function setPost($postFields, $varFields, $pos = 1){
		curl_setopt($this->ch, CURLOPT_POST, $pos );
		$this->setPostfields($postFields, $varFields);
		return $this;
	}

	public function setPostfields($postFields, $varFields){
		$this->postFields = vsprintf($postFields, $varFields);
		return $this;
	}

	public function close(){
		curl_close($this->ch);
	}
	public function setSSL($valor){
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $valor);
		//curl_setopt($this->ch, CURLOPT_VERBOSE, 1); 
		//curl_setopt($this->ch,CURLOPT_SSL_VERIFYHOST,2);
		return $this;
	}
	
	public function setOpt($opt, $value){
		curl_setopt($this->ch, $opt, $value);
		return $this;
	}
	
	public function setSSLVersion($version){
		curl_setopt($this->ch, CURLOPT_SSLVERSION, $version);
		return $this;
	}

	public function setPort($port){
		curl_setopt($this->ch,CURLOPT_PORT, $port);
		return $this;
	}
	
	public function get(){
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirection
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, "/tmp/");
		curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");

		if ($this->postFields){
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->postFields);
		}
	
		return curl_exec($this->ch);
	}
	
	public function getError(){
		return curl_error($this->ch);
	}

}
/*
* Ejemplo Utilizacion Curl
*
$d = new Curl(); // instacia

//Ejemplo con logeo 
$d->setUrl("http://www.ayrasoftware.es/intranet2/seg/conexion.php")
		->setPost(1)
		->setPostfields("aswg_us=%s&aswg_pw=%s", array("root","root"))->get();

//Ejemplo con url en esta como antes hemos hecho el logeo se guarda, las variables de sesion.
echo $d->setUrl("http://www.ayrasoftware.es/intranet2/men/rpLeft.php")->setPost(0)->get()->setClose();
*>
$d = new Curl();
echo $d->setUrl("http://www.google.es/search?q=curl+variables")->get();
$d->setClose();
*/
