<?

class DebugController extends Controller{
	
	protected $controller = "app/Debug";

	public function __construct(){
		parent::__construct("Controller_gen.tpl");
	}

	public function secure(){
		//parent::secure();
		if (!UserLogic::isAllowedDebug()){
			UserLogic::notAllowed();
		}
	}
	public function getTemplate($ejecuciones, $tabs) {
		$tpl = new Template("debug.tpl");
		$tpl->setVar("ejecucion", $ejecuciones);
		$tpl->setVar("tabs", $tabs);
		return $tpl->parse();
	}
	
	protected function setBotones( $cont ){
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("ACTIVAR","img/tick.png","window.location='".$this->controller.".activa'","Activar");
		FACTORIE::getDefault()->ControlToolbar()->addButtonPrimary("DESACTIVAR","img/stop.png","window.location='".$this->controller.".desactiva'","Desactivar");
		
	}

	public function defaultAction(HashTable $cont){
		$this->setJS(new HashTable("js/jquery.js"));
		
		$this->setBotones( $cont );
		
		$order = new HashTable();
		$order->id = "DESC";

		$ds				= App::getDS("DEBUG");
		$sqlCab 		= FACTORIE::getDefault()->DebugCabeceraRS()->setOrder($order)->sql();
		$resultadoCab	= $ds->exec($sqlCab);
		$search 			= new Search();
		$search->setHeaders(new HashTable("EJECUCIONES"));
		$search->setRS($ds, $resultadoCab);
		$search->setInput(false);
		$search->setFields(new HashTable(array("ruta")));
		$search->setTrAction("".$this->controller.".detalle?id=%s", array("id"));


		$cont->body  = FACTORIE::getDefault()->ControlAjax()
		->setName("ajax_prueba")
		->setUrl("$(this).attr('onClick')")
		->setDisparador(".odd", "click")
		->setDivLoading("#contentAjax", "'Cargando'")
		->setFunction("",'$("#tabs").tabs()')
		->setResponse("#contentAjax")->parse();
		
		$tabs = FACTORIE::getDefault()->ControlTabs()->setName("tabs")
		->addTab("LOGS", "")
		->addTab("SQLS", "")
		->addTab("GET", "")
		->addTab("POST", "")
		->addTab("SESSION", "")
		->parse();
		
		$cont->body .= 	$this->getTemplate( $search->getOutput(), $tabs);

		$cont->toolbar = FACTORIE::getDefault()->ControlToolbar()->parse();


	}
	
	public function backtraceAction( HashTable $cont) {
		
		$debug = DebugORM::getDefault()->getByPk(App::request()->idDebug);
		
		$back	= @unserialize(base64_decode($debug->backtrace));
		$search 			= new Search();
		$search->setHeaders(new HashTable(array("File", "Class", "Function", "line")));
		$search->setRS($back);
		$search->setInput(false);
		$search->setFields(new HashTable(array("file", "class", "function", "line")));
		$search->setTrAction("".$this->controller.".detalle?id=%s", array("id"));
		$cont->body ="";
		if ($debug->tipo == "SQL"){
			if (stripos($debug->txt, "SELECT") === 0){
				$cont->body .= "<a href='app/".$this->controller.".query?sql=".base64_encode($debug->txt)."'>Resultado</a><br/>";
				$cont->body .= "<a href='app/".$this->controller.".query?sql=".base64_encode("EXPLAIN " .$debug->txt)."'>Explain</a>";
			}
		}
		
		$cont->body .= $search->getOutput();
	}
	
	public function detalleAction(HashTable $cont){

		$ds			 = App::getDS("DEBUG");

		//BUSCAMOS LAS DE TIPO LOG
		$filters 	 = new HashTable();
		$filters->id = App::request()->id;
		$filters->tipo = "LOG";

		$sql 		= FACTORIE::getDefault()->DebugRS()->sql($filters);
		$resultado	= $ds->exec($sql);
		$search2       = new Search();
		$search2->setHeaders(new HashTable(array("Valor", "Time")));
		$search2->setRS($ds, $resultado);
		$search2->setInput(false);
		$search2->setTrAction("window.open('".$this->controller.".backtrace?idDebug=%s','d','height=300,width=800,status=1,scrollbars=1')", array("id_debug"));
		$search2->setFields(new HashTable(array("txt", "time")));
		$LOG = $search2->getOutput();

		//BUSCAMOS LAS DE TIPO SQL
		$filters 	 = new HashTable();
		$filters->id = App::request()->id;
		$filters->tipo = "SQL";
		$sql 		= FACTORIE::getDefault()->DebugRS()->sql($filters);

		$resultado2	= $ds->exec($sql);
		$search       = new Search();
		$search->setHeaders(new HashTable(array("Valor", "Time")));
		$search->setRS($ds, $resultado2);
		$search->setInput(false);
		$search->setTrAction("window.open('".$this->controller.".backtrace?idDebug=%s','d','height=300,width=800,status=1,scrollbars=1')", array("id_debug"));
		$search->setFields(new HashTable(array("txt", "time")));
		$SQL = $search->getOutput();

		$debug = DebugCabeceraORM::getDefault()->getByPk(App::request()->id);

		echo FACTORIE::getDefault()->ControlTabs()->setName("tabs")
		->addTab("LOGS", $LOG)
		->addTab("SQLS", $SQL)
		->addTab("GET", $this->getGlobal($debug->get))
		->addTab("POST", $this->getGlobal($debug->post))
		->addTab("SESSION", $this->getGlobal($debug->session))
		->parse();
		exit;

	}
	public function getGlobal( $value ){
		return "<pre>".var_export(unserialize(base64_decode($value)),true)."</pre>";
	}

	public function activaAction(HashTable $cont){
		Session::set("_DEBUG_", 1);
		$this->defaultAction($cont, $http,$model);
	}
	public function desactivaAction(HashTable $cont){
		Session::set("_DEBUG_", 0);
		$this->defaultAction($cont, $http,$model);
	}

	public function queryAction(HashTable $cont){
		$ds = App::getDS();
		$query = (base64_decode(App::request()->sql));
		//$pr = new Paginator($ds, $query, 30, Http::r());
		$resultado = $ds->exec($query);

		FACTORIE::getDefault()->Search()->setHeaders(new HashTable($ds->getHeaders()));
		FACTORIE::getDefault()->Search()->setRS($ds,$resultado);
		FACTORIE::getDefault()->Search()->setInput(false);
		FACTORIE::getDefault()->Search()->setForm(ControlForm::getDefault()->setName("formulario")->setMethod("POST"));
		FACTORIE::getDefault()->Search()->setFields(new HashTable($ds->getHeaders()));
		$cont->body = FACTORIE::getDefault()->Search()->getOutput();
		$cont->toolbar = $query;
	}


	public function reportarAction(HashTable $cont){
		$debug =  Debug::loadDebugSerialize();
		$m = new Mail();
		Log::add($debug);
		$m->setFrom(APPNAME."@meditrial.es")
		->addTo("victor.blanco84@gmail.com")
		->addAdjuntoTxt($debug, APPNAME."_debug.txt")
		->setAsunto(APPNAME."")->sendMail();

	}

}
