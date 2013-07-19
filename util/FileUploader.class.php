<?php

class FileUploader extends Object{
	
	protected $destination = null;
	protected $file_name = null;
	protected $error= null;
	
	const EXTENSION = 1;
	const NO_SUBIDO = 2;
	
	
	public function __construct(){
		parent::__construct();
		return $this;
	}		
	
	public function __destruct(){
		unset($this);
	}
	
	public function setDestination($value){
		$this->destination = $value;
		return $this;
	}
	
	public function setFileName($value){
		$this->file_name = $value;
		return $this;
	}
	
	function upload($key,$extensions=null){
    	//datos del arhivo
        $partes                 = explode(".",$_FILES[$key]['name']);
        $ext                 	= $partes[count($partes)-1];

        $nombre_archivo = $this->file_name.".".$ext;
        
        if(!is_array($extensions) || (in_array(strtolower($ext),$extensions))){
        	if (move_uploaded_file($_FILES[$key]['tmp_name'], $this->destination."/".$nombre_archivo)){
	           	return $nombre_archivo;
			}else{
				$this->error = self::NO_SUBIDO;
				return false;
			}
	    }else{
	    	$this->error = self::EXTENSION;
	    	return false;
	    }

	}
	
	function uploadSeveral($key,$extensions=null){
    	//datos del arhivo
    	$salida 	= array();
    	$errores 	= array();
    	$cont		=0;
    	foreach($_FILES[$key]["name"] as $ind => $file){
    		
    		$cont++;
    		$partes                 = explode(".",$file);
        	$ext                 	= $partes[count($partes)-1];
	
	        $nombre_archivo = $this->file_name."_".$cont.".".$ext;
	        if(!is_array($extensions) || (in_array(strtolower($ext),$extensions))){
	        	if (move_uploaded_file($_FILES[$key]['tmp_name'][$ind], $this->destination."/".$nombre_archivo)){
	           		$salida[] = $nombre_archivo;
				}else{
					$errores[] = $nombre_archivo;
				}
	    	}
    	}
    	return array($salida,$errores);
	}
	
}