<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
* Clase para control de outputs cacheados.
*/

abstract class CacheOutput extends Object{

    /**
	*		@Access: Private
	*
	*/
    private $log = false;

	/**
	*		@Access: Private
	*
	*/
    private  $_update = false;

	/**
	*		@Access: Private
	*
	*/
    protected  $_cache;

	/**
	*		@Access: Private
	*
	*/
    protected  $_static_attrs = array();

	private  $pathFile = null;

	/**
	* Constructor.
	*
	*/
    public function __construct () {
		parent::__construct();
        $pathCache = $this->_getCachePath ();
		$this->_cache = new Cache (basename($pathCache), dirname($pathCache));
    }
	
	public function __destruct(){
		unset($this);
	}

	/**
	* 
	*
	*/
    private function _generateStaticObject () {
		$fullpath = DIR_CACHE_OUTPUT.get_class($this)."#".$this->_getKeyName().".ser";
		if (!@stat($fullpath)){
			if ($f = @fopen($fullpath,"w")){
				if(@fwrite($f,serialize($this)))@fclose($f);
			}else Debug::add("<b>ERROR: CacheOutput. No pudo escribir serializado en $fullpath</b>");
		}
	}
	
	public function removeCacheFile(){
		return unlink($this->pathFile);
	}
	
	/**
	* 
	*
	*/
    private function _unlinkStaticObject () {
        @unlink(DIR_CACHE_OUTPUT.get_class($this)."#".$this->_getKeyName().".ser");
    }

	/**
	* Metodo que gestiona la cache de disco del output.
	*
	*/
    public function getOutput() {

		
		$fileCacheName = $this->_getKeyName ();
		$cacheTime=intval($this->_getCacheTime ());
		$pathFC = $this->_cache->getCacheNameFile($fileCacheName);
		
		$this->pathFile = $pathFC;
		
		$fileToCheck = $this->_getFileToCheck ();
		if ($fileToCheck) $fileToCheckTime = @filemtime($fileToCheck);
		$regenerar = false;

		$tracecache = Http::$get->tracecache;
		
		Debug::add("-----------------------------------------------------------------------");
		Debug::add("CLASS ".strtoupper(get_class($this))."");
		
		if (!$this->_update){
			if (!($st = @stat($pathFC))) {
				$this->_update = true;
			}else{
				if (!$cacheTime){
				if ($fileToCheck && ($st['mtime'] < $fileToCheckTime))
				$regenerar=true;
				}else{
					if ((time() - $st['mtime']) > $cacheTime){
					$regenerar = true;
					$this->setUpdate();
					}
				}
			}

			if (Http::$get->regenerate == true && !isset($this->_notRegenerate) ) 	$this->_update = true;
		}

	
		Debug::add("FORZADO = $this->_update ");

		if ($this->_update){
		
			$class = strtoupper(get_class($this));
			
			Debug::add(date ("d-m-Y H:m:s") . " CLASS: $class CACHE NAME: $fileCacheName");

			Debug::add(" CACHE TIME: $cacheTime ");
			
			try{
				$contenido = $this->_getContent ();
				$this->_unlinkStaticObject ();
				//  Limpio de blancos
				//	$contenido=preg_replace('/([ \t]*[\r\n]+[ \t]*)+/', "\n", $contenido);
				//	$contenido=preg_replace('/[ \t]+/', ' ', $contenido);

				$patron = ".*#DYN#[a-z A-Z]*#DYN#.*";
				if(ereg($patron,$contenido)){
					$data = explode("#DYN#",$contenido);
					if(is_array($data)){
					
						$c = 0;
						foreach($data as $k => $v){
							if($c == 1){
								$valor ="";
								if(method_exists($this,$v)){
									$valor = $this->$v();
								}
								$contenido = ereg_replace("#DYN#$v#DYN#",$valor,$contenido);
								$c=-1;
							}
							$c++;
						}
					}
				}

				$this->writeCache ($fileCacheName, $contenido);
				
				Debug::add(">>>>>>>>>>>>>ESCRIBO CACHE $fileCacheName <<<<<<<<<<<<<<");
				
				return $contenido;

			}catch(Exception $e) {
				$regenerar=true;
				Debug::add("<b>**** ERROR GENERANDO MODULO $class: ".$e->getMessage()."</b>");
			}
			
		}

		// Envio de la regeneracin del m dulo
		Debug::add("CHECK REFRESCO: Time = $cacheTime IDCACHE=$fileCacheName TIME=".time()." <> CACHE=".filemtime($this->_cache->getCacheNameFile($fileCacheName))." DIF= ".(time()- filemtime($this->_cache->getCacheNameFile($fileCacheName)))."");
		
		if ($fileToCheck) 
			Debug::add("REF FICHERO: $fileToCheckTime. DIF= ".($fileToCheckTime - filemtime($this->_cache->getCacheNameFile($fileCacheName)))."");


		if ($regenerar){
		
			Debug::add("************* MANDO REFRESCO ************ (".(time() - filemtime($this->_cache->getCacheNameFile($fileCacheName)))."sg.)");
			
			$this->_generateStaticObject ();
			
			Debug::add(">>>>ESCRIBO SERIALIZADO OBJETO $fileCacheName <<<<");
		}
		Debug::add("LEO CACHE $fileCacheName ");        
		$contenido = @$this->readCache ($fileCacheName);

		return $contenido;
    }

	/**
	*
	*
	*
	*/
    public function setUpdate () {
        $this->_update = true;
    }

    abstract protected function _getContent ();
	
    abstract protected function _getKeyName ();
	
    abstract protected function _getCachePath ();

	/**
	*
	*
	*
	*/
    protected function _getCacheTime () {
        return false;
    }
    
	/**
	*
	*
	*
	*/
    private function _getFileToCheck () {
        return false;
    }

	/**
	*
	*
	*
	*/
	private function start() {
		$fileCacheName = $this->_getKeyName ();
		$pathFC = $this->_cache->getCacheNameFile($fileCacheName);

		$st = @stat($pathFC);

		if (!$st){
			$this->setUpdate ();
			$this->getOutput ();
			$st = @stat($pathFC);
			if (!$st) return 0;
		}
		if ($st['size'] == 0)return 0;

		return $st['mtime'];
	}

	/**
	*
	*
	*
	*/
    private function writeCache($key, $contenido){

		if ($this->_static_attrs){
			$content = '$contenido='.var_export($contenido, true).";\n";
			foreach ($this->_static_attrs as $attr)
			$content .= "\$this->$attr=".var_export($this->$attr, true).";\n";
			$this->_cache->writeCache ($key, $content);
		}else $this->_cache->writeCache ($key, $contenido);
    }


	/**
	*
	*
	*
	*/
    private function readCache($key){
		$contenido = $this->_cache->readCache ($key);
		if ($this->_static_attrs) eval($contenido);
		return $contenido;
    }

}
?>
