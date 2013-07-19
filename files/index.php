<?php
require_once "conf.php";

class Application extends ApplicationBase{

	public static function run(){
		try{
		parent::run();
		Debug::add("APP: Iniciando aplicación");
		$contenido = null;
		
			App::getDefault();
			
			$controller 	= App::getController();
			$action 		= App::getAction();
			$cont 			= new $controller();
			
			$contenido 		=  $cont->getOutput($action);
		}catch(AccessException $e){
			App::redirect("app/Profile.errorPermission");
		}catch(GenException $e){
			if(ENTORNO == DESARROLLO){
				require("../error.php");
			}else{
				App::redirect("app/Profile.errorGen");
			}
		//}catch(DBException $e){ die("app/Profile.errorDB");
		//}catch(TemplateException $e){ die("app/Profile.errorTemplate");
		}catch(Exception $e){
			Log::add($e);
			require("../error.php");
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
		
		if (View::isPDF()){
			try{
			
			$pdf = ASPDF::getDefault(); // Creamos una instancia de la clase HTML2FPDF
			$pdf->addPage();
			$pdf -> WriteHTML($contenido);//Volcamos el HTML contenido en la variable $html para crear el contenido del PDF
			$pdf -> Output();	
			}catch(Exception $e){ Log::add($e); }
		}else{
			echo $contenido;
		}	
		parent::end();
		
	}
}

session_start();
Application::run();


