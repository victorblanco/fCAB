<?php 
//error_reporting(1);
set_error_handler('error_handler',E_ALL & ~E_NOTICE );//|  E_ALL | E_NOTICE | E_STRICT );
//set_error_handler('error_handler',E_ALL | E_NOTICE | E_STRICT );

//set_exception_handler('exception_handler');


define("PRODUCCION" ,1);
define("DESARROLLO" ,2);
define("APPNAME" ,"FRAMEWORK");
define("MAIL" ,"victor.blanco84@gmail.com");
define("IS_SUB_CARPETA",1);
define("PROTOCOL","http://");
define("ENTORNO", DESARROLLO);
define("proyect","");

define("SEGURIDAD_PAGINA", 1);

define("REGENERATE",1);

################## DATE ##################
define("SECONDS",0);
define("MINUTES",1);
define("HOURS",2);
define("DAY",3);
define("WEEKDAY",4);
define("MONTH", 5);
define("WEEKYEAR",6);
define("YEAR",7);
define("WEEK",8);
define("TIMEZONE",9);

############### DATE FORMAT ################
define("DATE_FORMAT_DEFAULT",0);
define("DATE_FORMAT_SHORT",1);
define("DATE_FORMAT_MEDIUM",2);
define("DATE_FORMAT_LONG",3);
define("DATE_FORMAT_FULL",4);
define("DATE_FORMAT_SQL",5);
define("TIME_FORMAT_DEFAULT",0);
define("TIME_FORMAT_SHORT",1);
define("TIME_FORMAT_LONG",2);
define("TIME_FORMAT_FULL",3);
define("TIME_FORMAT_SQL",4);


################## DIR ####################
define("CONTROLS","controls/");
define("CLASES","clases/");
define("RS","rs/");
define("RESOURCES","i18n/resources/");
define("DECORATOR","decorators/");
define("I18N","i18n/");
define("ORM","orm/");
define("CONTROLLER","controller/");
define("EXCEPTION","exception/");
define("SERIALIZED","SERIALIZED/");
define("INTERFACES","INTERFACES/");
define("PDF","pdf/");
/**
 * Entornos de cores 
 * 
 */
$ENTORNOS 			= array("propias", "connecto",  "core");
$ENTORNOS_CONSOLE 	= array("console");


define("clases", "clases/");
define("controller", "controller/");
define("controls", "controls/");
define("decorator", "decorator/");
define("exception", "exception/");
define("i18n", "i18n/");
define("resource", i18n."/resources/");
define("orm", "orm/");
define("pdf", "pdf/");
define("rs", "rs/");
define("admin", clases."/admin/");
define("mobile", clases."/mobile/");
define("interfaces", "interfaces/");
define("sql", "sql/");
define("templates", "templates/");
define("util", "util/");
define("chart", "chart/");
define("smarty", "smarty/");
define("DATA", "DATA/");
define("TEST","test/");
define("tpl_dir","templates/");
define("controls_tpl_dir","controls/templates/");
define("tpl_pre",tpl_dir."PRES");
define ("cache_path",SERIALIZED);

############### LOGICA DE SUBCARPETA ################

if (IS_SUB_CARPETA != 0){
	if ($_SERVER['PATH_INFO']){
		$url_virtual = $_SERVER['PATH_INFO'];
		list($url_fisica ) = explode("app",$_SERVER['REQUEST_URI']);
	}else{
		list($url_fisica , $url_virtual) = explode("app",$_SERVER['PHP_SELF']);
		if ($url_virtual == "/index.php" || $url_virtual == "/index_console.php" )
			$url_virtual = "";
	}

	define("SUB_CARPETA","".implode("/",explode("/",$url_fisica))."");
	define("RUTA_APP"	,"".implode("/",explode("/",$url_virtual))."");

}else{
	define("SUB_CARPETA","/");

}
//echo $_SERVER['DOCUMENT_ROOT'];
define("BASE","");
define("PRIV",BASE."");
define("VIEW",BASE."view/");

define("CONF",PRIV."CONF/");
define("LOG",PRIV."log/");
define("log_file",LOG.date("W")  . "_log_file.txt");

$path = array(
				util,
				clases,
				controller,
				orm,
				rs,
				sql,
				controls ,
				decorator,
				exception,
				interfaces,
				resource,
				i18n,				
				pdf,				
				chart,
				admin,
				mobile
				);

function error_handler( $errno, $errmsg, $file, $line, $ctxt ) {
	if ( error_reporting() == 0 ) return;
	$msg = sprintf( 'Error %d: %s (%s:%d)', $errno, $errmsg, $file, $line );
	Log::add($msg);

	if(ENTORNO == DESARROLLO)	 pprint($msg);
}

function pprint( $var ) {
	if ( !defined( 'STDIN' ) ) echo '<pre>';
	switch( gettype( $var ) ) {
		case 'array':
			print_r( $var );
			break;
		case 'object':
			if ( is_subclass_of( $var, 'Object' ) ) {
				echo $var;
			} else {
				printf( "Object ID#%s - No __toString() method.", spl_object_hash( $var ) );
			}
			break;
		default:
			echo $var;
	}
	if ( !defined( 'STDIN') ) echo '</pre>';
}

function exception_handler( Exception $exception ) {
	$msg = $exception->getMessage();
	echo $msg;
	Log::add($msg);
}

function __autoload($class_name) {
	global $ENTORNOS;
	global $path;
	$incluida = false;
	
	foreach($path as $val){
		foreach($ENTORNOS as $carpeta){
			//ECHO BASE;//.$carpeta."/".$val.$class_name . ".class.php\n<br>";
			if (is_file(BASE.$carpeta."/".$val.$class_name . '.class.php')){
				$incluida = true;
				require_once(BASE.$carpeta."/".$val.$class_name . '.class.php');
				return;	
			}
		}
		if ($incluida) break;
	}
	
	if(!$incluida){
		Log::add("404 $class_name no encontrada");die("404 $class_name no encontrada"); };
}


if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}
