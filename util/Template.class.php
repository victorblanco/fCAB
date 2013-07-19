<?php

/**
 *	Aplication Name: Self - Framework V 2.0
 *
 *	Author: V�ctor Blanco
 *	Date: 10/02/2008
 *	Company:
 * Clase para el manejo de templates.
 * Esta clase proporciona un mtodo de saber qu  templates se estn recompilando.
 * Para ello existe el modo debug controlado por el atributo $debug.
 *
 */
class Template extends Object{

	/**
	 * Atributo que contiene el nombre y ruta del fichero TPL.
	 *
	 * @access private
	 * @var string
	 */
	private $nameTemplate;

	/**
	 * Atributo que contiene el nombre y ruta del fichero PRE (precompilado de templates).
	 *
	 * @access private
	 * @var string
	 */
	private $namePrecompile;

	/**
	 * Atributo que contiene el bloque, la variable y el valor a parsear a la template.
	 *
	 * @access private
	 * @var string
	 */
	public $vars;

	/**
	 * Atributo que contiene el resultado del parseo de las variables en la template.
	 *
	 * @access private
	 * @var string
	 */
	private $result;

	/**
	 * Atributo que contiene el contenido del fichero TPL.
	 *
	 * @access private
	 * @var string
	 */
	private $content;

	/**
	 * Atributo que contiene bloques, variables y su posicion dentro del fichero TPL.
	 *
	 * @access private
	 * @var array
	 */
	public $bloque;

	protected $traductor;
	protected $namePreCompileItt;


	public $bfuncs = array();
	
	/**
	 * Constructor.
	 *
	 * @access public
	 * @param string $nameTpl Nombre del fichero TPL.
	 * @param string $pathTpl Path del fichero TPL.
	 * @param string $pathPre Path del fichero PRE.
	 * @return mixed Un nuevo Objeto Template si no se produce ning n error o TemplateException.
	 *
	 */
	function __construct($nameTpl, $pathTpl = tpl_dir){
		$this->setPre($nameTpl , $pathTpl);

		$nameTpl = $this->fullPath ($pathTpl.$nameTpl);
		$pathTpl = $this->fullPath ($pathTpl);

		$pathSpt = __FILE__ ;
		$this->nameTemplate = $nameTpl;

		$timeTpl 	= @filemtime($this->nameTemplate);
		$timePre 	= @filemtime($this->namePrecompile);
		$timePreItt = @filemtime($this->namePreCompileItt);
		$timeSpt 	= @filemtime($pathSpt);

		# Si la tpl es ms moderna o ha cambiado la version de esta lib
		if ((($timeTpl > $timePre) || ($timeSpt > $timePre)) || App::isITT() || $timePreItt > $timePre) {
			$retValue = $this->compiler();

		}else{
			include ($this->namePrecompile);
		}

		$this->result = null;
		return $this;

	}

	public function setPre($nameTpl, $pathTpl){
		$entornos 				 = App::getEntornos();
		$pos_punto 				 = strrpos ($nameTpl, '.');
		$namePre 				 = substr($nameTpl,0,$pos_punto)."_".App::getLocale().".pre";
		$this->namePrecompile	 = BASE.$entornos[0]."/".$pathTpl."PRES/".$namePre;
		$this->namePreCompileItt = BASE.$entornos[0]."/".$pathTpl."PRES/".substr($nameTpl,0,$pos_punto)."_".".itt";
		if (App::isITT()){
			 $this->namePrecompile  = $this->namePreCompileItt;
		}
	}

	public function setDomain($domain){
		$this->dominio = $domain;
		return $this;
	}

	private function compruebaRuta($dir){
		$ENTORNOS =  $this->getEntornos();
		foreach ($ENTORNOS as $e){
			if (!is_dir($e."/".$dir)){
				Debug::add("ERROR: No existe el directorio de template $dir.");
				throw new TemplateException("No existe el directorio de template $dir.");
			}
		}

	}
	private function compruebaFichero($fichero){
		$ENTORNOS =  $this->getEntornos();
		$existe = false;
		foreach ($ENTORNOS as $e){
			if (is_file($e."/".$fichero)){
				$existe = true;
				break;
			}
		}
		if (!$existe){
			Debug::add("ERROR: No existe el fichero $fichero.");
			throw new TemplateException("No existe el fichero $fichero.");

		}

	}

	public function __destruct(){
		unset($this);
	}


	/**
	 * M todo estatico que retorna el nombre de la clase.
	 *
	 * @access public
	 * @return string Nombre de la clase.
	 */
	public function getClassName () {
		return "Template";
	}


	private function getEntornos(){
		return App::getEntornos();
	}

	private function getTranslation($txt, $clave, $sinTraduccion = 0, $dominio = ""){
		if (App::isITT()){
			$tpl_trads = new Template("ITT.tpl");
			$tpl_trads->setVar("txt", "$txt");
			if ($sinTraduccion){
				$tpl_trads->setVar("dominio", $this->traductor->getDomain());
			}else{
				$tpl_trads->setVar("dominio", $dominio);
			}
			$tpl_trads->setVar("clave", $clave);
			if ($sinTraduccion){
				$tpl_trads->setVar("style", $tpl_trads->parseBlock("SIN_TRADUCCION"));
			}else{
				$tpl_trads->setVar("style", $tpl_trads->parseBlock("CON_TRADUCCION"));
			}
			return addcslashes($tpl_trads->parse(), "\"\\\$");

		}else{
			return $txt;
		}
	}

	private function fullPath ($fichero) {
		$existe = false;
		$entornos = $this->getEntornos();

		foreach ($entornos as $e){
			if (file_exists(BASE.$e."/".$fichero)){
				$existe = true;
				$ruta = BASE.$e."/".$fichero;
				break;
			}
		}
		if (!$existe){
			Debug::add("ERROR: No existe el fichero $fichero.");
			throw new TemplateException("No existe el fichero $fichero.");

		}
		return $ruta;

	}


	/**
	 * M todo que almacena en un array valores del conjunto bloque, variable.
	 *
	 * @access public
	 * @param string $varName Nombre de la variable a parsear.
	 * @param string $value Valor de la variable a parsear.
	 * @param string $nameBlock Nombre del bloque de parseo.
	 */
	public function setVar ($varName, $value = "", IDecorator $decorator = null) {
		$this->setVarBlock("MAIN", $varName, $value, $decorator);
		return $this;
	}


	/**
	 * Mtodo que almacena en un array valores del conjunto bloque, variable a traves de setVar.
	 * @access public
	 * @param string $nameBlock Nombre del bloque de parseo.
	 * @param string $varName Nombre de la variable a parsear.
	 * @param string $value Valor de la variable a parsear.
	 */
	public function setVarBlock ($nameBlock, $varName, $value = "", IDecorator $decorator = null) {

		if (!is_null($decorator)){
			 $value = $decorator->decorate($value);
		}
		try{
			if (!is_array($varName) && !is_object($varName)) {
				if (!empty ($varName)){
					$this->vars[$nameBlock][$varName] = $value;
				}
			}else {
				reset ($varName);
				foreach($varName as $key => $value) {
					if (!empty ($key)){
						if (!is_null($decorator)){
							 $value = $decorator->decorate($value);
						}

						$this->vars[$nameBlock][$key] = $value;
					}
				}
			}
		}catch (Exception $e){
			Debug::add($e);
		}
		return $this;
	}

	/**
	 * M todo que permite comprobar la existencia de una variable
	 * @access public
	 * @param string $nameBlock Nombre del bloque de parseo.
	 * @param string $varName Nombre de la variable a parsear.
	 */
	public function existsVar($varName){
		return $this->existsVarBlock("MAIN", $varName);
	}

	public function existsVarBlock($nameBlock, $varName){
		return isset($this->vars[$nameBlock][$varName]);
	}

	/**
	 * 	@Desc Funci�n que devuelve todas las variables de un bloque
	 *  @param string $nameBlock Nombre del bolque
	 *  @return array
	 */
	public function getVarsByBlock( $nameBlock ){
		return $this->vars[$nameBlock];
	}



	/**
	 * Mtodo que obtiene la cadena resultante del parseo de variables de toda la template.
	 *
	 * @access public
	 * @return string Cadena resultante del parseo de toda la template.
	 */
	public function parse() {
		$f = $this->bfuncs['MAIN'];
		if ($f) $this->result = $f($this->vars['MAIN']);
		return $this->result;
	}


	/**
	 * M todo que obtiene la cadena resultante del parseo de un bloque.
	 *
	 * @access public
	 * @param string $nameBlock Nombre del bloque.
	 * @boolean $resetBlock Indica si se inicializa o no el bloque,
	 * por defecto no se inicializa
	 * @return string Cadena resultante del parseo del bloque.
	 */
	public function parseBlock ($nameBlock,$resetBlock=false) {

		$f = @$this->bfuncs[$nameBlock];
		// Si es un bloque valido ...
		if ($f) {
			$data = $f($this->vars[$nameBlock]);
			if ($resetBlock)
			$this->resetVars($nameBlock);
		}
		else $data="";
		return $data;
	}


	/**
	 * Mtodo que resetea las variables del bloque
	 *
	 * @access public
	 * @param string $nameBlock Nombre del bloque.
	 * @return void
	 */
	public function resetVars($nameBlock="MAIN") {
		if (!is_null(@$this->vars[$nameBlock])) {
			foreach(array_keys(@$this->vars[$nameBlock]) as $var)
			@$this->vars[$nameBlock][$var]="";
		}
		return $this;
	}


	/**
	 * M todo que muestra por pantalla el resultado del parseo.
	 *
	 * @access public
	 */
	public function printResult() {
		if (is_null($this->result)) $this->parse();
		print $this->result;
	}


	/**
	 *  Genera el fichero pre
	 */
	private function compiler() {

		$curr_blk="MAIN";

		# Stacks para guardar las longitudes de los bloques (para la deteccion de fin de bloque)
		# y cul es el bloque pr vio (contexto en el que se defini el bloque en curso)
		$sp=-1;
		$block_len_stk=array();
		$block_prev_stk=array();

		$pf = fopen ($this->nameTemplate, "r");
		$content = fread($pf, filesize ($this->nameTemplate));
		fclose($pf);

		$content = addcslashes($content, "\"\\\$");

		$bloque["MAIN"][] = array(0,strlen($content));

		$pos=0;


		while (($pos=strpos($content, '<!-- ', $pos)) !== false ){
			$posIni = $pos;
			$pos+=5;
			$tipo=$content[$pos];
			if ($tipo != '@' && $tipo != '{' && $tipo != '[' && $tipo != '#') continue;
			switch ($tipo){
				case '{':
					$pos++;
					$pos2 =  strpos($content, '} -->', $pos);

					if (!$pos2){
						Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
						throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
					}

					$varData=substr($content, $pos, $pos2-$pos);
					list($varName, $varMods) = $this->getVarModifiers($varData);

					$this->vars[$curr_blk][$varName]="";
					$pos= $pos2+5;
					$bloque[$curr_blk][]=array($varName,$posIni,$pos,$varMods,false, null);
					break;
				case '@':
					$pos++;
					if ($content[$pos++] != ' ') continue;

					$pos2 = strpos($content, ' @ -->', $pos);

					if (!$pos2){
						Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable de bloque no cerrada");
						throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable de bloque no cerrada");
					}

					$varName=substr($content, $pos, $pos2-$pos);
					$pos= $pos2+6;

					// Fin de Bloque, hacemos pop del stack de bloques anidados
					if ($sp >=0 && $pos == $block_len_stk[$sp]) {
						$curr_blk = $block_prev_stk[$sp];
						$sp--;
					}else{
						$posFin = strpos($content, "<!-- @ $varName @ -->", $pos);
						if (!$posFin){
							Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Fin de bloque \"$varName\" no hallado");
							throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Fin de bloque \"$varName\" no hallado");
						}

						$tagLen = strlen("<!-- @ $varName @ -->");
						$bloque[$curr_blk][]=array($varName,$posIni,$posFin + $tagLen, NULL, false, null);

						$sp++;
						$block_len_stk[$sp] = $posFin + $tagLen;
						$block_prev_stk[$sp] = $curr_blk;
						$curr_blk = $varName;

						if (isset($bloque[$curr_blk])){
							Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Bloque \"$varName\" duplicado");
							throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Bloque \"$varName\" duplicado");
						}
						$bloque[$curr_blk][]=array($pos,$posFin);
						$this->vars[$curr_blk][$varName]="";
					}
					break;
				case '#':
					Debug::add("Compilando con el idioma".App::getLocale());
					$pos++;
					$pos2 = strpos($content, '# -->', $pos);

					if (!$pos2){
						Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
						throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
					}

					$varData					=substr($content, $pos, $pos2-$pos);
					
					list($varName, $varMods) 	= $this->getVarModifiers($varData);
					list($varName, $varsTrads)	= $this->getVarTrads($varName);
					
					Debug::add("Traduccion : $varName = ".$this->traductor->$varName);
					$this->traductor = App::getTranslator();

					/*if ($this->traductor->$varName){
						$varName = $this->getTranslation($this->traductor->$varName, $varData, 0, $this->traductor->getLastDomain());
					}else{
						$varName = $this->getTranslation($varData, $varData,1);
					}**/
					$varName = 	addcslashes($this->traductor->$varName, "\"\\\$");

					$this->vars[$curr_blk][$varName]="";
					$pos= $pos2+5;
					$bloque[$curr_blk][]=array($varName,$posIni,$pos,$varMods,true, $varsTrads);
					break;
				case '[':
					Debug::add("A�adiendo Templante");
					$pos++;
					$pos2 = strpos($content, '] -->', $pos);

					if (!$pos2){
						Debug::add("ERROR: $this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
						throw new TemplateException("$this->nameTemplate. Linea ".$this->getLineAtOffset($content,$pos).". Variable no cerrada");
					}

					$varData=substr($content, $pos, $pos2-$pos);
					list($varName, $varMods) = $this->getVarModifiers($varData);
					$tpl = new Template($varData);
					$varName = addcslashes($tpl->parse(), "\"\\\$");

					$this->vars[$curr_blk][$varName]="";
					$pos= $pos2+5;
					$bloque[$curr_blk][]=array($varName,$posIni,$pos,$varMods,true, null);
					break;

			}

		}

		# Escritura del precompilado
		if (!$fp = @fopen ($this->namePrecompile,"w")){
			throw new TemplateException("$this->namePrecompile no pudo abrirse para escritura");
		}
		if ($fp) fputs($fp, "<?php\n");

		foreach ($bloque as $block_name=>$vars){
			if (list($ini, $fin) = $vars[0])
			$blk_content = substr($content, $ini, $fin-$ini);
			else { $blk_content = $content; $ini=0; }
			$correccion=-$ini;

			for ($i=1; $i<count($vars); $i++) {
				list($varName, $ini, $fin, $mods, $traduccion, $trads) = $vars[$i];
				if ($fp && !$traduccion){
					fputs($fp, "\$this->vars['$block_name']['$varName']='';\n");
				}

				if ($mods){
					if ($traduccion){
						if (!App::isITT()){
							if($trads){
								$str2 = "\".Template::applyModifiers(sprintf(\"$varName\"". $this->getVarsTrads($trads)."),\"$mods\").\"";
							}else{
								$str2 = Template::applyModifiers("$varName","$mods");
							}
						}else {
							$str2 = "$varName";
						}
					}else{
						$str2 = "\".Template::applyModifiers(\$vars[\"$varName\"],\"$mods\").\"";
					}
				}else{
					if ($traduccion){
						if($trads){
							$str2 = "\".sprintf(\"$varName\"". $this->getVarsTrads($trads).").\"";
						}else{
							$str2 = $varName;
						}
						//$str2   = "\".\$vars[\"$varName\"].\"";
					}else{
						$str2 = "\".\$vars[\"$varName\"].\"";
					}
				}
					$blk_content = substr_replace($blk_content, $str2, $ini+$correccion, $fin-$ini);
					$correccion += strlen($str2) - ($fin-$ini);
			}

			@$this->bfuncs[$block_name] = @create_function('$vars', "return \"$blk_content\";");
			$blk_content = addcslashes($blk_content, "\'");
			if ($fp)
			fputs($fp, "\$this->bfuncs['$block_name']=create_function('\$vars','return \"$blk_content\";');\n");
		}
		if ($fp){
			fputs($fp, "?>");
			fclose($fp);
		}

		return true;
	}
	
	protected function getVarsTrads($trads){
		$vars 	= explode(",", $trads);
		$tmp	= ""; 
		foreach($vars as $var){
				$tmp .= ", \$vars[\"$var\"]";
		}	

		return $tmp;		
	}



	private function getLineAtOffset($content,$current_pos)  {
		$n=1;
		$pos=-1;
		while (($pos = strpos($content, "\n", $pos+1)) !== false && $pos < $current_pos)
		$n++;

		return $n;
	}

	private function getVarModifiers($varStr)  {
		if ($pos = strpos($varStr, '|'))
		return array(substr($varStr, 0, $pos), substr($varStr, $pos+1));
		else
		return array($varStr, NULL);
	}
	
	private function getVarTrads($varStr)  {
		if ($pos = strpos($varStr, ':'))
		return array(substr($varStr, 0, $pos), substr($varStr, $pos+1));
		else
		return array($varStr, NULL);
	}

	static function applyModifiers($data, $modifers)  {

		$origdata = $data;
		$modData = Template::argExplode('|', $modifers);

		for ($i=0; $i<count($modData); $i++){

			$modArgs= Template::argExplode(':', $modData[$i]);
			$modName = $modArgs[0];
			$modArgsCount = count($modArgs) -1;

			switch ($modName){
				case "upper":
					if ($modArgsCount == 0)
					$data=strtoupper($data);
					else {
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "lower":
					if ($modArgsCount == 0)
					$data=strtolower($data);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "trim":
					if ($modArgsCount == 0)
					$data=trim($data);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "ucword":
					if ($modArgsCount == 0)
					$data=mb_convert_case($data, MB_CASE_TITLE, "UTF-8"); 
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "ucfirst":
					if ($modArgsCount == 0)
					$data=ucfirst(strtolower($data));
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "escape":
					if ($modArgsCount <= 1)	{
						if ($modArgsCount == 0) $modArgs[1]="html";

						switch ($modArgs[1]){
							case "html":
								$data=htmlspecialchars($data);
								break;
							case "html_all":
								$data=htmlentities($data);
								break;
							case "quotes":
								$data=addslashes($data);
								break;
							case "url":
								$data=urlencode($data);
								break;
							case "raw_url":
								$data=rawurlencode($data);
								break;
							case "javascript":
								$data=addcslashes($data, "\0..\37'\"\\\177..\377");
								break;
							case "utf8":
								$data=utf8_encode($data);
								break;
							default: throw new TemplateException("ERROR: Bad argument for $modName");
						}
					}else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "nl2br":
					if ($modArgsCount == 0)
					$data=nl2br($data);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "ifnull":
					if ($modArgsCount == 1){
						if (is_null($data)) return($modArgs[1]);
					}else {
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "signon":
					if ($modArgsCount == 0){
						if ($origdata>0) $data="+$data";
					}else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "wordwrap":
					if ($modArgsCount == 1)
					$data=wordwrap($data, $modArgs[1]);
					else if ($modArgsCount == 2)
					$data=wordwrap($data, $modArgs[1], $modArgs[2]);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "replace":
					if ($modArgsCount == 2)
					$data=str_replace($modArgs[1], $modArgs[2], $data);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "strip_tags":
					if ($modArgsCount == 1)
					$data=strip_tags ($data, $modArgs[1]);
					else if ($modArgsCount == 0)
					$data=strip_tags ($data);
					else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				case "pad":
					$modes = array("L"=>STR_PAD_LEFT, "R"=>STR_PAD_RIGHT, "B"=>STR_PAD_BOTH);
					if ($modArgsCount == 3)
					$data=str_pad($data, $modArgs[1], $modArgs[2], $modes[$modArgs[3]]);
					else throw new TemplateException("ERROR: Bad argument count to $modName");
					break;
				case "truncate":
					if ($modArgsCount > 0 && $modArgsCount <= 3){
						$length = $modArgs[1];
						$tail = (($modArgsCount>1) ? $modArgs[2] : "...");
						$atword = (($modArgsCount>2) ? ($modArgs[3]=="true") : true);
						if ($atword)
						for ($pos=$length; $pos>0 && $data[$pos] != ' '; $pos--);
						else
						$pos = $length;
						$data = substr($data,0,$pos).$tail;
					}else{
						throw new TemplateException("ERROR: Bad argument count to $modName");
					}
					break;
				default: // Si no es ninguna de esta es un Decorator
					$decorator = FACTORIE::getDefault()->$modName(array_slice($modArgs, 1));
					$decorator->__construct(array_slice($modArgs, 1));
					$data=$decorator->decorate($data);

					break;
			}
		}
		return $data;
	}


	static function argexplode($sep, $str)  {
		return explode($sep, $str);
	}

}

