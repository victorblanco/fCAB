<?php
function seteaArray($array, &$array2){
	foreach($array as $key => $item){
		$array2[$key] = $item;
	}
}

function creaArrayParametros(){
	$temp = array();
	foreach ($_SERVER['argv'] as $argumento){
		$argumentos = explode("=",$argumento);
		if (count($argumentos) == 2){
			$temp[$argumentos[0]] = $argumentos[1];
		}
	}
	return $temp;
}
$file	= __FILE__;
$partes = explode("/",$file);
$partes[count($partes) - 2] = "";
$partes[count($partes) - 1] = "";

$_SERVER['DOCUMENT_ROOT']	= implode("/",$partes);
$_SERVER['PWD']				= implode("/",$partes);
$_SERVER['OLDPWD']			= "/";

$_SERVER['PATH_INFO'] 	= "/".$_SERVER['argv'][1];
$_SERVER['PHP_SELF'] 	= "/app/".$_SERVER['argv'][1];


$parametros = creaArrayParametros();
seteaArray($parametros, $_REQUEST);
seteaArray($parametros, $_GET);
seteaArray($parametros, $_POST);
require_once("index.php");

