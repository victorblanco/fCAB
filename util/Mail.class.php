<?

class Mail{
	protected $from;
	protected $to;
	protected $cc;
	protected $cco;
	protected $asunto;
	protected $body;
	protected $boundary;
	protected $adjunto;
	protected $adjuntoTxt;

	function __construct(){
		$this->boundary	 =  $this->getBoundary();
		$this->adjunto		 = array();
		$this->adjuntoTxt	 = array();
		$this->to			 = array();
		$this->to			 = array();
		$this->cc			 = array();
		$this->cco			 = array();
		$this->index2 		 = 0;
		$this->index1		 = 0;

	}

	public function sendMail(){
		mail($this->getTo(), $this->asunto, $this->getBody(), $this->getHeaders());
	}
	
	public function getTo(){

		return implode(",", $this->to);
	}

	public function getBody(){
		$body  = "--".$this->boundary."\r\n";
		$body .= "Content-Type: text/html; charset=UTF-8\n";
		$body .= "Content-Transfer-Encoding: 8bit\n\n";
		$body .= $this->body;

		foreach ($this->adjunto as $adjunto){
			$f 		 = new FileReader($adjunto['txt']);
			$txt		 = $f->getTxt();
			$archivo  = chunk_split(base64_encode($txt));
			$body 	.= "--".$this->boundary."\r\n";
			$body 	.= "Content-Type: ".mime_content_type($adjunto['txt'])."; name=\"".$adjunto['name']."\"; charset=UTF-8;\n";
			$body 	.= "Content-Transfer-Encoding: base64\n";
			$body 	.= "Content-Disposition: attachment; filename=\"".$adjunto['name']."\"\n\n";
			$body 	.= $archivo;
		}
		
		foreach ($this->adjuntoTxt as $adjunto){
			$body		 .= "--".$this->boundary."\r\n";
			$body		 .= "Content-Type: text/plain; name=\"".$adjunto['name']."\"; charset=UTF-8;\n";
			$body	 	 .= "Content-Transfer-Encoding: base64\n";
			$body	  	 .= "Content-Disposition: attachment; filename=\"".$adjunto['name']."\"\n\n";
			$body     .= chunk_split(base64_encode($adjunto["txt"]));
		}

		if($this->adjunto || $this->adjuntoTxt){
			$body .= "--".$this->boundary."\r\n";
		}

		return $body;
	}

	public function addAdjunto($ruta, $name){
		$this->adjunto[$this->index1]["txt"] 	= $ruta;
		$this->adjunto[$this->index1]["name"] 	= $name;
		$this->index1++;
		return $this;
	}

	public function addAdjuntoTxt($txt, $name){
		$this->adjuntoTxt[$this->index2]["txt"] 	= $txt;
		$this->adjuntoTxt[$this->index2]["name"] 	= $name;
		$this->index2++;
		return $this;
	}

	public function addTo($to){
		$this->to[] = $to;
		return $this;
	}

	public function setFrom($form){
		$this->from = $form;
		return $this;
		
	}

	public function setAsunto($asunto){
		$this->asunto = $asunto;
		return $this;
	}
	
	public function setBody($body){
		$this->body = $body;
		return $this;
	}

	private function getBoundary(){
		return "----".APPNAME."----".md5(time());
	}

	private function getHeaders(){
		$cabeceras  = "MIME-Version: 1.0\r\n";
		$cabeceras .= "Content-Type: multipart/mixed; boundary=\"".$this->boundary."\"\n";
		$cabeceras .= "To: ".$this->getTo()."\r\n";
		$cabeceras .= "From: ".$this->from."\r\n";

		return $cabeceras;

	}


}
/*
$m = new Mail();
$m->setFrom("victor@imaweb.net")
	->addTo("victor.blanco84@gmail.com")
	->addAdjunto("Mail.php", "hola.php")
	->addAdjuntoTxt("Oee", "hola.txt")
	->setAsunto("88888")->sendMail();
*/
