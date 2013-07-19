<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: V�ctor Blanco
*	Date: 10/02/2008
*	Company:
*/



define("SOCKET_USLEEP_TIME", 100000);

/**
 * Clase gen�rica para el uso de sockets, utiliza sockets no bloqueantes.
 *
 * @author    Virgilio Sanz <vsanz@prisacom.com>
 * @version $Revision: 1.7 $
 * @copyright Prisacom S.A.
 * @abstract Clase gen�rica para el uso de sockets
 */
class Socket extends Object {
	/**
	*    IP/hostname del host al que quermos conectar
	*    @access private
	*/
	var $host = false;
	
	/**
	*    Puerto al que queremos conectar.
	*    @access private
	*/
	var $port = 80;
	
	/**
	*    tiempo de espera m�ximo para abrir el s�cket
	*    @access private
	*/
	var $conexionTimeout = 5.0;
	
	/**
	*    Tiempo de espera m�ximo para una petici�n
	*    @access private
	*/
	var $peticionTimeout = 30.0;
	
	/**
	*    Contiene el �ltimo número de error.
	*    @access private
	*/
	var $errno;
	
	/**
	*    Contiene la descripci�n del �ltimo error.
	*    @access private
	*/
	var $errstr;
	
	/**
	*    variable con la conexi�n (valor devuelto por fsockopen)
	*    @access private
	*/
	var $sp = false;
	
	
	/**
	*    Inicializa el objeto.
	*
	*    @access public
	*    @param string $host IP/nombre del host a conectar
	*    @param integer $port Puerto al que quermos conectar
	*/
    function __construct($host="127.0.0.1", $port = 80) {
        parent::__construct();
		
        $this->setHost($host);
        $this->setPort($port);
    }

	public function __destruct(){
		unset($this);
	}
	
	/**
	* Devuelve el valor de $host
	* @access public
	* @returns string
	*/
	function getHost() {
		return ($this->host);
	}

	/**
	* Devuelve el valor de $port
	* @access public
	* @returns integer
	*/
	public function getPort() {
		return ($this->port);
	}

	/**
	* Devuelve el valor de $port
	* @access public
	* @returns integer
	*/
	public function getConexionTimeout() {
		return ($this->conexionTimeout);
	}

	/**
	*    Devuelve el tiempo de espera m�ximo para una petici�n
	*    @access public
	*    @returns float
	*/
    public function getPeticionTimeout() {
        return ($this->peticionTimeout);
    }

	/**
	*    devuelve la conexi�n (valor devuelto por fsockopen)
	*    @access public
	*/
    public function getSocket() {
        return($this->sp);
    }

	/**
	* Asigna el host
	* @access public
	* @param $host string nombre/IP del host.
	*/
	public function setHost($host) {
	   $this->host = $host;
	}

	/**
	* Asigna el puerto a conectar
	* @access public
	* @param $port integer
	*/
	public function setPort($port) {
		$this->port = $port;
	}

	/**
	* Asigna el timeout para abrir una conexi�n
	* @access public
	* @param $float ct
	*/
	public function setConexionTimeout($ct) {
	   $this->conexionTimeout = $ct;
	}

	/**
	* Asigna el timeout de espera en una petici�n
	* @access public
	* @param float $pt
	*/
    public function setPeticionTimeout($pt) {
        $this->peticionTimeout = $pt;
    }
	
	/**
	*    Realiza la conexi�n con el host
	*
	*    @access public
	*    @returns bool true si va bien
	*/
    public function open() {
        if (is_resource($this->sp)) {
            $this->close();
        }

        $this->sp = fsockopen($this->host,
                              $this->port,
                              &$this->errno,
                              &$this->errstr,
                              $this->conexionTimeout);
        if (!$this->sp) {
            throw new Exception($this->errstr);
        }

		#  socket_set_blocking($this->sp, false);
        return true;
    }

	/**
	*    Cierra la conexi�n con el host
	*
	*    @access public
	*    @returns
	*/
    public function close() {
        if (is_resource($this->sp)) {
            @fclose($this->sp);
            $this->sp = false;
        }
    }

	/**
	* Devuelve true si el socket est� abierto. False en caso contrario.
	*
	* @returns boolean
	*/
    public function isOpened() {
        return (false == $this->sp ? false : true);
    }

	/**
	*    Lee $nchars caracteres del socket.
	*
	*    @access public
	*    @returns string
	*    @param int $nchars Número de caracteres a leer
	*/
    public function read($nchars) {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        // Calculo cuando deber� acabar de leer tenga o no lo que pido.
        $maxTime = $this->time() + $this->peticionTimeout;
        $data = "";
		$remain=$nchars;
        while (($this->time() < $maxTime) && !feof($this->sp) && $remain>0) {
            $leido = fread($this->sp, $remain);
            if (false == $leido) {
                usleep(SOCKET_USLEEP_TIME); // Duermo por medio segundo.
            } else {
                $data .= $leido;
		$remain -= strlen($leido);
            }
        }
        return($data);
    }
	
	/**
	*    Lee una l�nea del socket
	*
	*    @access public
	*    @returns string L�nea leido 
	*/
    public function readline() {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        // Calculo cuando deber� acabar de leer tenga o no lo que pido.
        $maxTime = $this->time() + $this->peticionTimeout;
        $data = "";
        $finished = false;
        while (($this->time() < $maxTime) && !$finished) {
            $leido = fgets($this->sp, 1024);
            if (false == $leido) {
                usleep(SOCKET_USLEEP_TIME); // Duermo por medio segundo.
            } else {
                $data .= $leido;
                if (strlen($data) >= 2 &&
                   (substr($data, -2) == "\r\n" ||
                    substr($data, -1) == "\n")) {
                    $finished = true;
                }
                if (feof($this->sp)) {
                    $finished = true;
                }
            }

            if (feof($this->sp) && !$finished) {
                if ($data == "") {
                    $data = EOF;
                }
                $finished = true;
            }
        }
        return($data);
    }

    public function readChunked() {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        // Calculo cuando deber� acabar de leer tenga o no lo que pido.
        $maxTime = $this->time() + $this->peticionTimeout;
        $data = "";
        $finished = false;
		$n=1;
        while (($this->time() < $maxTime) && !$finished) {
            $leido = trim(fgets($this->sp, 1024));
	    // Lectura de la longitud del chunk en hex. Viene en linea aparte
	    list($len)=sscanf($leido, "%x");
	    if ($len > 0)   {
			while ($len>0)	{
				$leido = fread($this->sp, $len);
				if (false == $leido) {
					usleep(SOCKET_USLEEP_TIME); // Duermo por medio segundo.
				} else {
					$data .= $leido;
					$len -= strlen($leido);
				}
			}
			fgets($this->sp, 3);
	    }
	    else break;
        }
        return($data);
    }

	/**
	*    Identico a la funci�n file() de php
	*
	*    @access public
	*    @returns array Array con las l�neas le�das del socket, sin el "\n"
	*/
    public function file() {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        $maxTime = $this->time() + $this->peticionTimeout;
        $data = array();
        while (!feof($this->sp) && ($this->time() > $maxTime)) {
            $line = $this->readline();
            if ($line != EOF) {
                $data[] = $line;
            }
        }

        if (!feof($this->sp)) {
            throw new Exception("ERROR: Se produjo un timeout de espera");
        }

        return($data);
    }

	/**
	*    Identica a la funci�n readfile de php.
	*
	*    @access public
	*    @returns string contenido del socket 
	*/
    public function readfile() {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        $maxTime = $this->time() + $this->peticionTimeout;
        $data = "";
        while (!feof($this->sp) && ($this->time() < $maxTime)) {
            $leido = fread($this->sp, 1024);
            if (false == $leido) {
                usleep(SOCKET_USLEEP_TIME); // Duermo por medio segundo.
            } else {
                $data .= $leido;
            }
        }

        if (!feof($this->sp)) {
            throw new Exception("ERROR: Se produjo un timeout de espera");
        }

        return($data);
    }
	
	/**
	*    Env�a el contenido de $data al socket
	*
	*    @access public
	*    @returns bool
	*    @param string $data Contenido a env�ar.
	*/
    public function send($data) {
        if (!is_resource($this->sp)) {
            throw new Exception('ERROR: No conectado');
        }

        $maxTime = $this->time() + $this->peticionTimeout;
        while ($this->time() < $maxTime) {
            $ret = fwrite($this->sp, $data, strlen($data));
            // Si hubo error duermo y vuelvo a intentarlo hasta dar timeout.
            if (false == $ret) {
                usleep(SOCKET_USLEEP_TIME);
            } else {
                return true;
            }
        }
        throw new Exception("ERROR: Sending data: TIMEOUT");
    }
	
	/**
	*    Devuelve el númerop de segundos desde el Unix Epoc, tiene precisi�n
	*    hasta microsegundos
	*
	*    @access protected
	*    @returns float
	*/
    function time() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}

?>
