<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class IniFile extends Object{

	/**
	* Atributo que contiene el nombre del fichero INI.
	*
	* @access private
	* @var array
	*/
    private $filename;
	
    private $fileContent;

    /**
      * Atributo que contiene la longitud del fichero.
      *
      * @access private
      * @var int
      */
    private $lon;

    /**
      * Constructor.
      *
      * @access public
      * @param string $name Nombre del Fichero INI que se quiere procesar.
          * @param string $errorClass Nombre de la clase de error que se lanzar�.
      *
      */
    public function __construct($name) {
        $this->filename = $name;
        parent::__construct(); // Llamada al constructor de la clase padre
		
        if (!@($this->fileContent = file($name, 1)))   {
            throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No existe el fichero $name.<br>");
        }

        $this->lon = count($this->fileContent);
    }

	public function __destruct(){
		unset($this);
	}
	
 
	/**
	* Deja en una tabla hash (que le pasamos por referencia) todos los valores de un grupo determinado.
	* Los nombres de cada campo estan en MAYUSCULAS por defecto. El modo viene indicado por el parámetro
	* "modo".
	*
	* @access public
	* @param string $grupo Grupo del que se quiere obtener los valores.
	* @param array $varRet Array en el que se devuelven los resultados de la consulta.
	* @param $modo Modo en el que se quiere que se devuelvan las "keys" del Array de retorno
	*        Puede tomar dos valores "UP" (may�sculas) y "LOW" (min�sculas) (cualquier otro valor
	*        deja las cosas como est�n).
	*
	* @return array Hash con los valores de los datos contenidos en el grupo consultado.
	*/
    public function getGroup( $grupo, $modo="UP" )
        {
        $varRet=array();
        $i = 0;
        $grpEnc = 0;
        $grupo = strtoupper( $grupo );
        while( $i < $this->lon )
            {
            $linea = $this->fileContent[$i++];
            if ( ereg( "\n", $linea ) )
            {
                $linea = chop($linea);
            }

            if ( (!empty($linea) ) && ($linea[0] == '#') )
                $linea = "";

            list($linea) = split( "//", $linea );
            if ( $grpEnc == 0 )
            {
                $linea = strtoupper( $linea );
                if ( ereg( "\[$grupo\]", $linea ) )
                    $grpEnc = 1;
            }
            else
            {

                if ( ereg( "^\[", $linea ) )    return;
                else{
				
					$key=substr($linea,0,strpos($linea,"="));
					$valor=substr($linea,strpos($linea,'=')+1);
					if ( strlen($key) && strlen($valor) )   {
						$valor =  trim($valor);
						$key= trim($key);
						if ($modo=="UP")
							$key=strtoupper($key);
						elseif ($modo=="LOW")
							$key=strtolower($key);
						$varRet[$key] = $valor;
					}
                }
            }
        }
		return $varRet;
    }

	/**
	* Devuelve por referencia un array con las etiquetas de los grupos que tenga el fichero INI.
	*
	* @access public
	* @param array $varRet Array con los nombres de los grupos.
	*/
    public function listGroup( )  {
		$grupos = array();
		$i = 0 ;

		while( $i < $this->lon )
		{
			$linea = $this->fileContent[$i++];
			if ( ereg( "\n", $linea ) ) { $linea = chop($linea); }
				if ( (!empty($linea) ) && ($linea[0] == '#') )
					$linea = "";
				list($linea) = split( "//", $linea );
			$ini = strchr( $linea, "[" ) ;
			if ( $ini >= 0 )
			{
				$fin = strchr( $linea, "]" ) ;
				if (( $fin >= 0 ) && ( $fin > $ini ))
						$grupos[] = substr( $linea, $ini+1, $fin-1 ) ;
			}
		}

		return  $grupos ;
        }


	/**
	* Devuelve un MAYIniFile generando un fichero en caso de que no exista
	* 
	* @access public
	* 
	* @param string $fileName ruta completa y nombre del fichero
	*/
    public static function getIni($fileName){
        if(!@file_exists($fileName)){
            if (!$nf = @fopen($fileName,'w')){
                throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede abrir el fichero $fileName.<br>");
                return $this; 
            }
            $contenido="# Nuevo Fichero";
           // Escribir $contenido a nuestro arcivo abierto.
            if (@fwrite($nf, $contenido) === FALSE) {
                throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
                return $this; 
            }

            fclose($nf);
        }
        return new IniFile($fileName);
    }

	/**
	* Sobrescribe el fichero sustituyendo el grupo modificado y si no existe lo crea
	*
	* @access public
	*
	* @param string $group nombre del grupo a crear o modificar
	* @param array $content valores del grupo
	*
	*/
    public function saveGroup($group, array $content){       
        $fileName=$this->filename;
        if (!$nf = @fopen($fileName,'w')){
			
            throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede abrir el fichero $fileName.<br>");
            return $this;  
        }   
        $grupos = $this->listGroup();

        foreach($grupos as $nombreGrupo){

            if($nombreGrupo!=$group){             
                if (@fwrite($nf, "\n[$nombreGrupo]\n") === FALSE) {
                   throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
                    return $this;  
                }  
                $ret = $this->getGroup($nombreGrupo);                      
                foreach($ret as $key => $value){            
                    if (@fwrite($nf, "$key=$value\n") === FALSE) {
                       throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
                        return $this;  
                    }    
                }           
            }

        }
        if (@fwrite($nf, "\n[$group]\n") === FALSE) {
            throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
            return $this;  
        }  


        foreach($content as $key => $value){            
            if (@fwrite($nf, "$key=$value\n") === FALSE) {
                throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");  
                return $this;  
            }    
        }  

        fclose($nf);
        return true;
    } 

	/**
	* Sobrescribe el fichero eliminando un grupo
	*
	* @access public
	*
	* @param string $group nombre del grupo a eliminar
	*
	*/
    public function removeGroup($group){       
        $fileName=$this->filename;
        if (!$nf = @fopen($fileName,'w')){
            throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede abrir el fichero $fileName.");
            return $this;  
        }   
        $grupos = $this->listGroup();

        foreach($grupos as $nombreGrupo){

            if($nombreGrupo!=$group){             
                if (@fwrite($nf, "\n[$nombreGrupo]\n") === FALSE) {
                   throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
                    return $this;  
                }  
                $ret = $this->getGroup($nombreGrupo);                      
                foreach($ret as $key => $value){            
                    if (@fwrite($nf, "$key=$value\n") === FALSE) {
                        throw new Exception("��� ERROR !!! (".__FILE__.",". __LINE__.") => No se puede escribir el fichero $fileName.<br>");
                        return $this;  
                    }    
                }           
            }

        }

        fclose($nf);
        return true;
    } 

}

?>
