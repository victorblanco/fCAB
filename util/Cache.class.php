<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

abstract class Cache extends Object {

	
	protected $filename;
	
	protected $prefolder;	
	
	protected $content;

	protected $regenerate = false;

	protected $serializedData = null; 


	/**
	* @Description: Constructor
	*
	* @Access: public
	* @return: $this
	* @Params: void
	*/
	public function __construct(){
	 	parent::__construct();
		$this->serializedData = new HashTable();
	}

	/**
	* @Description: Se debe sobreescribir este método
	*
	* @Access: public
	* @return: String
	* @Params: void
	*/
	abstract function getKey();
		

	/**
	* @Description: Retorna los segundos a comprobar en el cacheo
	*
	* @Access: Public
	* @return: integer
	* @Params: oid
	*/
	abstract function getTime();


	/**
	* @Description: Retorna el directorio donde se almacena la cache
	*
	* @Access: Public
	* @return: String
	* @Params: Void
	*/
	abstract function getPath();




	/**
	* @Description: Elimina el fichero de Cache
	*
	* @Access: Public
	* @return: Bolean
	* @Params: Void
	*/
	public function deleteCache(){

		$file = new File($this->getRealFilePath());
		return $file->delete();
	}
	
	/**
	* @Description: Nos permite agregar objetos y serializarlos, se accede desde el método
	* 		getContent() de la calse hija
	* @Access: Protected
	* @return:Void
	* @Params:$name, nombre de la variable ; $value, valor de la variable 
	*		puede ser cualquier cosa, generalmente se utiliza para objetos
	*
	* TODO: Probablemente este método deba ser público	
	*/
	protected function addSerialized($name,$value){
		$this->serializedData->$name = $value;
	}
	
	/**
	* @Description: Retorna el objeto contenido en la variable $name del hashTable serializado
	*
	* @Access: Public
	* @return: Object
	* @Params: $name, nombre de nuestra referencia
	*/
	public function getSerialized($name){
		return $this->serializedData->$name;
	}

	/**
	* @Description: Nos permite obtener el hashTable con los objetos serializados
	*
	* @Access: Public
	* @return:Rtorna un objeto de tipo HashTable unserialized
	* @Params:Void
	*/
	public function getAllSerialized(){
		return $this->serializedData;
	}


	/**
	* @Description: Forzamos a que se regenere la cache
	*
	* @Access: Public
	* @return: Void
	* @Params: opcional default true;
	*/
	public function setUpdate($value = true){
		$this->regenerate = $value;
		return $this;
	}

	
	/**
	* @Description: Método que comprueba si debe regenerar la cache
	*
	* @Access: Protected
	* @return: Bolean
	* @Params: filetime del cacheFile
	*/
	protected function regeneraCache($filetime){

		if ($this->regenerate === true or (boolean)Http::$get->regenerate === true) return true;

		if ($this->getTime() == 0) return false;

		if( $this->diferenceTime($filetime) > $this->getTime() ) return true;

		return false;
	}

	private function diferenceTime($filetime){
		return (time() - $filetime);
	}

	/**
	* @Description: Construye el path completo del fichero en el que se va a cachear
	*
	* @Access: Private
	* @return: String path
	* @Params: Void
	*/
	private function getRealFilePath(){
		return $this->getPath().$this->prefolder."/".$this->filename;
	}


	/**
	* @Description: Es el arranque del programa, es este método que debemos de llama
	* 		al construir el objeto
	*
	* @Access: Publico
	* @return: String
	* @Params: Void
	*/
	public function getOutput(){
	
		try {
			if (is_null($this->getKey())) 	throw new Exception("ERROR: No se ha seteado el Key");
			if (is_null($this->getPath())) 	throw new Exception("ERROR: No se ha seteado el path");
			
			$this->filename 	= md5($this->getKey());
			$this->prefolder 	= substr($this->filename,0,3);
	



			# creamos el preDir
			$dir = new DirIterator($this->getPath().$this->prefolder);
			
			
			if(!$dir->valid()) {
				if(!$dir->create($this->getPath(),$this->prefolder))
					throw new Exception("ERROR: no se ha podido crear [$this->prefolder] en el dir [".$this->getPath()."]");
			}
			

			$file = new File($this->getRealFilePath());
			if(!$file->isFile()){
			
				$content = null;
				
				try {
					$content = $this->getContent();
					
					$file->open("w+");
					$file->write($content);
					Debug::add("CACHE: Escribo en cache en [".$this->getRealFilePath()."]" );
					
					if(!$file->isFile()) 
						throw new Exception("ERROR: Imposible crear el fichero [".$this->getRealFilePath()."]");

					$file->close();			
					
					//unset($file);
					
					$this->serializedData->this = clone $this;
					if ($this->serializedData->count() > 0){
					
						$serialize = new File($this->getRealFilePath().".ser");
						$serialize->open("w+");
						$serialize->write(serialize($this->serializedData));
						$serialize->close();
						//unset($serialize);
					}

				}catch(Exception $e){
					Debug::add($e);
					throw $e;
				}

				return $content;
			}
			
			
			if( $this->regeneraCache($file->fileTime()) ){
				
				$content = null;
				
				try {
					$content = $this->getContent();

					$file->open("w+");
					$file->write($content);
					$file->close();
					
					Debug::add("CACHE: Escribo en cache en [".$this->getRealFilePath()."]" );
					
					$this->serializedData->this = clone $this;
					if ($this->serializedData->count() > 0){
						
						$serialize = new File($this->getRealFilePath().".ser");
						$serialize->open("w+");
						$serialize->write(serialize($this->serializedData));
						$serialize->close();
						//unset($serialize);
					}

				}catch(Exception $e){
					Debug::add($e);
					throw $e;
				}
				
				$serialize = new File($this->getRealFilePath().".ser");
				if(!$serialize->isFile()) Debug::add("ERROR: No existe el fichero serializado");
				else $this->serializedData = unserialize($serialize->getContent()); 
				
				//unset($serialize);
				
				Debug::add("CACHE: Leo Cache KEY [".$this->getKey()."] 
						Time ".$this->diferenceTime($file->fileTime()) ."] CacheTime[".$this->getTime()."]");
				
				//unset($file);
				
				return $content;
			}
			
			Debug::add("CACHE: Leo Cache KEY [".$this->getKey()."] Time 
						[".$this->diferenceTime($file->fileTime()) ."] CacheTime[".$this->getTime()."]");
			
			
			$serialize = new File($this->getRealFilePath().".ser");

			if(!$serialize->isFile()) Debug::add("ERROR: No existe el fichero serializado");
			else $this->serializedData = @unserialize($serialize->getContent()); 
			
			return $file->getContent();
		
		}catch(Exception $e){
			Debug::add($e);
			throw $e;
		}

		return null;
	}	
	

}

/**
Usage


class miClase extend Cache {

	$this->user = null;

	public function __construct($user_name){
		parent::__construct();
		$this->user = $user_name;
	}

	# podemos utilizar cualquier valor que identifique al objeto, 
	# por ejemplo si cacheamos usuarios, coches, etc, lo mas logico es
	# utilizar el id (DB id) , y un literal. y podremos recuperarlo 
	# sin tener que acceder a db
	public  function getKey(){

		return "miClase_" . $this->user;
	}
		
	# seconds 
	# si caduca el tiempo, el objeto se regenera ,
	# en caso contrario nos retorna lo que tenemos en la cache
	public  function getTime(){
		

		return 20000;
	}

	# directorio donde se creará la estructura de cacheo
	# en este caso utilizo una constante
	public  function getPath(){
		

		return cache_path;
	}

	# Este es protected porque se accede solamente desde la clase base 
	# cuando tiene que regenerar la cache, aqui podemos serializar los objetos
	# que deseamos o simplemente retornar un string que sera cacheado, 
	# La clase cachea lo que retorne este método
	# Las Exceptions se controlan en la clase base
	protected function getContent(){
		

		# parse string 
		.
		.

		# También puedo serializar objetos

		$this->addSerialized("coche", new Coche());
		$this->addSerialized("perro", new Perro());
		$this->addSerialized("gato", new Gato());

		.
		.
		.
		#return parse string;

	}
	

}



$miobject = new miClase();

$cont = $miobject->getOutput();

# la variable $cont almacena el string resultante de la lectura de la cache
# o del procesado de la clase segun configuremos el tiempo de cache


# podemos forzar la regeneracion de cache

$miobject = new miClase();
$miobject->setUpdate();

$cont = $miobject->getOutput();


# podemos Serializar automaticamente objetos y disponer de ellos
# indistintamente si leo o regenero la cache

$miobject = new miClase();
$cont = $miobject->getOutput();

$gato  = $miobject->getAllSerialized()->gato;
$perro = $miobject->getSerialized("perro");


*/
?>
