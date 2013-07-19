<?php
/**
*	Aplication Name: Self - Framework V 2.0
*
*	Author: Víctor Blanco
*	Date: 10/02/2008
*	Company:
*/

class XSLCompiler extends Object {
	
	protected $view = null;

	protected $viewcompiler = null;
	

	public function __construct($view){
		$this->view = $view ;
	}
	
	public static function getDefault($view){
		return new XSLCompiler($view);
	}
	
	
	public function compiler(){
		$locale = Locale::getDefault()->getLocale();
		
		if(!is_dir(VIEW.$locale)){
			if(!mkdir(VIEW.$locale,0644))
				throw new Exception("No se ha podido crear el directorio -> " .VIEW.$locale);
		}
	
		$view  = new File(VIEW.$this->view.".xsl");
		if(!$view->isFile()) 
			throw new Exception("No existe la vista -> " .VIEW.$this->view.".xsl");	
		
		$compiler = new File(VIEW.$locale."/".$this->view.".xsl");

				
		if(!$compiler->isFile())
			$this->createCompiler($compiler);
		
		
		
		if($view->fileTime() > $compiler->fileTime())
			$this->createCompiler($compiler);
		
		
		# return the path of tranlated compiler xsl file;
		return VIEW.$locale."/".$this->view.".xsl";
	}
	
	
	
	
	protected function createCompiler( File $compiler){
	
		$tpl = new Template($this->view.".xsl", VIEW, tpl_pre); 
		
		TranslatorOU::tpl($tpl,$this->view);

		$compiler->open("w+")->write($tpl->parse());
		
		$compiler->close();

	}

}


?>