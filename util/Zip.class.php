<?php

/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/


class Zip  extends Object{  
	var $compressedData = array(); 
	var $centralDirectory = array();
	var $endOfCentralDirectory = "\x50\x4b\x05\x06\x00\x00\x00\x00";
	var $oldOffset = 0;

	public function __construct(){
		parent::__construct();
	}

	public function __destruct(){
		unset($this);
	}
	
	function addDir($directoryName) {
		$directoryName = str_replace("\\", "/", $directoryName);  

		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x0a\x00";    
		$feedArrayRow .= "\x00\x00";    
		$feedArrayRow .= "\x00\x00";    
		$feedArrayRow .= "\x00\x00\x00\x00"; 

		$feedArrayRow .= pack("V",0); 
		$feedArrayRow .= pack("V",0); 
		$feedArrayRow .= pack("V",0); 
		$feedArrayRow .= pack("v", strlen($directoryName) ); 
		$feedArrayRow .= pack("v", 0 ); 
		$feedArrayRow .= $directoryName;  

		$feedArrayRow .= pack("V",0); 
		$feedArrayRow .= pack("V",0); 
		$feedArrayRow .= pack("V",0); 

		$this -> compressedData[] = $feedArrayRow;
		
		$newOffset = strlen(implode("", $this->compressedData));

		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .="\x00\x00";    
		$addCentralRecord .="\x0a\x00";    
		$addCentralRecord .="\x00\x00";    
		$addCentralRecord .="\x00\x00";    
		$addCentralRecord .="\x00\x00\x00\x00"; 
		$addCentralRecord .= pack("V",0); 
		$addCentralRecord .= pack("V",0); 
		$addCentralRecord .= pack("V",0); 
		$addCentralRecord .= pack("v", strlen($directoryName) ); 
		$addCentralRecord .= pack("v", 0 ); 
		$addCentralRecord .= pack("v", 0 ); 
		$addCentralRecord .= pack("v", 0 ); 
		$addCentralRecord .= pack("v", 0 ); 
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";  
		$addCentralRecord .= pack("V", 16 ); 

		$addCentralRecord .= pack("V", $this -> oldOffset ); 
		$this->oldOffset = $newOffset;

		$addCentralRecord .= $directoryName;  

		$this->centralDirectory[] = $addCentralRecord;  
		return $this;
		
	}	 
	
	function addFile($filename, $directoryName)   {
		$data=file_get_contents($filename);
 		$directoryName = str_replace("\\", "/", $directoryName);  
	
		$feedArrayRow = "\x50\x4b\x03\x04";
		$feedArrayRow .= "\x14\x00";    
		$feedArrayRow .= "\x00\x00";    
		$feedArrayRow .= "\x08\x00";    
		$feedArrayRow .= "\x00\x00\x00\x00"; 

		$uncompressedLength = strlen($data);  
		$compression = crc32($data);  
		$gzCompressedData = gzcompress($data);  
		$gzCompressedData = substr( substr($gzCompressedData, 0, strlen($gzCompressedData) - 4), 2); 
		$compressedLength = strlen($gzCompressedData);  
		$feedArrayRow .= pack("V",$compression); 
		$feedArrayRow .= pack("V",$compressedLength); 
		$feedArrayRow .= pack("V",$uncompressedLength); 
		$feedArrayRow .= pack("v", strlen($directoryName) ); 
		$feedArrayRow .= pack("v", 0 ); 
		$feedArrayRow .= $directoryName;  

		$feedArrayRow .= $gzCompressedData;  

		$feedArrayRow .= pack("V",$compression); 
		$feedArrayRow .= pack("V",$compressedLength); 
		$feedArrayRow .= pack("V",$uncompressedLength); 

		$this -> compressedData[] = $feedArrayRow;

		$newOffset = strlen(implode("", $this->compressedData));

		$addCentralRecord = "\x50\x4b\x01\x02";
		$addCentralRecord .="\x00\x00";    
		$addCentralRecord .="\x14\x00";    
		$addCentralRecord .="\x00\x00";    
		$addCentralRecord .="\x08\x00";    
		$addCentralRecord .="\x00\x00\x00\x00"; 
		$addCentralRecord .= pack("V",$compression); 
		$addCentralRecord .= pack("V",$compressedLength); 
		$addCentralRecord .= pack("V",$uncompressedLength); 
		$addCentralRecord .= pack("v", strlen($directoryName) ); 
		$addCentralRecord .= pack("v", 0 );
		$addCentralRecord .= pack("v", 0 );
		$addCentralRecord .= pack("v", 0 );
		$addCentralRecord .= pack("v", 0 );
		$addCentralRecord .= pack("V", 32 ); 

		$addCentralRecord .= pack("V", $this -> oldOffset ); 
		$this -> oldOffset = $newOffset;

		$addCentralRecord .= $directoryName;  

		$this -> centralDirectory[] = $addCentralRecord;  
		return $this;
	}

	function addAuthor() {
		$fp = fopen("zip_author_deletefile.deletefie_author_zip","w");
		fclose($fp);
		$this ->addFile("zip_author_deletefile.deletefie_author_zip","zipinfo.txt");
		unlink("zip_author_deletefile.deletefie_author_zip");
	}

	function getZip() { 
		$this -> addAuthor();
		$data = implode("", $this -> compressedData);  
		$controlDirectory = implode("", $this -> centralDirectory);  

		return   
			$data.  
			$controlDirectory.  
			$this -> endOfCentralDirectory.  
			pack("v", sizeof($this -> centralDirectory)).     
			pack("v", sizeof($this -> centralDirectory)).     
			pack("V", strlen($controlDirectory)).             
			pack("V", strlen($data)).                
			"\x00\x00";                             
	}
	function saveZip($filename) {
		$fp = fopen ($filename, "wb");
		fwrite ($fp, $this -> getZip());
		fclose ($fp);
		return $this;
	}
	
	function downloadZip($filename) {
		if(ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}
		elseif ( ! file_exists( $filename ) ) {
			exit;
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/zip");
		header("Content-Disposition: attachment; filename=".basename($filename).";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename));
		readfile("$filename");
		return $this;
	 }
}

# require('zipArchive.class.php');
# $zip = new zipArchive();
#  
# $dir = "directorio que deseamos comprimir";
#  
# $directorio=opendir($dir);
# while ($archivo = readdir($directorio)) {
# if(!is_dir("$dir/$archivo"))
# $zip->addFile($dir.'/'.$archivo, "image/$archivo");
# }
# closedir($directorio);
#  
# $pathSave = 'nombre.zip';
# $zip->saveZip($pathSave);
# $zip->downloadZip($pathSave);

?>
