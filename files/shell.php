<?php


require_once "conf.php";

class Application extends ApplicationBase{
	public static function run(){
		try{
			parent::run();
			Debug::add("APP: Iniciando aplicación");
			self::shell();	
		}catch(Exception $e){
			Log::add($e);
			parent::end();
			die;
		}


		# Close all connections	
		try {
			$ds = @App::getAllDS();
			if(is_array($ds)){
				foreach($ds as $connection){
					if($connection instanceOf DB)
						if(@$connection->isConnect()) $connection->close();
				}
			}
		}catch(Exception $e){
		}	
		parent::end();
		
	}
	public static function shell(){

		while(true){
			echo "> ";
			$re = fopen("php://stdin","r");
			$comman = "";
			if($data = fread($re,125)){
				$comman .= $data;
			}
			preg_match_all("#--[^\s]*#",$comman, $ret);
			$c = explode(" ",trim($comman));
			echo "Comando: " . $c[0] . "\n";
			echo "Parametros: \n";
			foreach($ret[0] as $param){
				$p = explode("=", $param);
				echo "\tParametro = {$p[0]}";
				if(count($p) > 1 ){
					echo " valor = {$p[1]}";
				}
				echo "\n";
			}
	
		}
	}

	public static function getControllerAction(){

	}
}

session_start();
Application::run();
