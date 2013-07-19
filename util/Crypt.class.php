<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class Crypt extends Object implements IFactory{

	private $k;

    function __construct($m=NULL){
	
       $args = func_get_args();
       if(empty($args))
          $this->k = 'lla*1249987¿¿¡*+`+!"·%/&)?)=(¿?)=@12%kqPO/\'ÇÇ·{BbÙ&lt;ºHtq(54?0!"·ª';
       else
          $this->k = $m;
    }
	
	public static function getDefault(){
		static $i = null;
		
		if(is_null($i)) $i = new Crypt();
		return $i;
	}


    function exec($a){
       if(substr($a,0,2)!='z#')
          return $this->encriptar($a);
       else
          return $this->desencriptar(substr($a,2));
    }

    private function ed($t){
       $r = md5($this->k);
       $c=0;
       $v = "";
       for ($i=0;$i<strlen($t);$i++) {
          if ($c==strlen($r)) $c=0;
          $v.= substr($t,$i,1) ^ substr($r,$c,1);
          $c++;
       }
       return $v;
    }

    private function encriptar($t){
       srand((double)microtime()*1000000);
       $r = md5(rand(0,32000));
       $c=0;
       $v = "";
       for ($i=0;$i<strlen($t);$i++){
          if ($c==strlen($r)) $c=0;
          $v.= substr($r,$c,1).(substr($t,$i,1) ^ substr($r,$c,1));
          $c++;
       }
       return 'z#'.base64_encode($this->ed($v));
    }

    private function desencriptar($t){
       $t = $this->ed(base64_decode($t));
       $v = "";
       for ($i=0;$i<strlen($t);$i++){
          $md5 = substr($t,$i,1);
          $i++;
          $v.= (substr($t,$i,1) ^ $md5);
       }
       return $v;
    }

    function __destruct(){
       $this->k = '';
    }
}


/*
usage

$encriptacion = new Crypt();
 // La llave tipo string seria opcional
 $encriptacion->krypto('lo que se quiere encriptar');
 $encriptacion->krypto('lo que se quiere desencriptar¡);
 // La función determinara si encripta o desencripta

*/


?>