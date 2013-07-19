<?php


class AdminBreadCrumbLogic extends Object{
	/**
	 * 
	 * @var array[index][controller]=value
	 * 					[action]=value
	 * 					[url]=value
	 * 					[title]=value
	 */
	static protected $miga;
	
	static function update($controller, $action, $params, $title, $level = null){
		
		$new_miga = array();
		
		if(Session::get("adminbc") != ""){
			try{
				self::$miga = unserialize(Session::get("adminbc"));	
			}catch(Exception $e){
				self::$miga = array();
			}
		}else{
			self::$miga = array();
		}
		$index = self::getIndex($controller,$action,$params,$level);
		for($i = 0; $i < $index;$i++){
			$new_miga[$i]['controller'] = self::$miga[$i]['controller'];
			$new_miga[$i]['action'] = self::$miga[$i]['action'];
			$new_miga[$i]['params'] = self::$miga[$i]['params'];
			$new_miga[$i]['title'] = self::$miga[$i]['title'];
		}
		$new_miga[$index]['controller']=$controller;
		$new_miga[$index]['action']=$action;
		$new_miga[$index]['params']=$params;
		$new_miga[$index]['title']=$title;
		
		self::$miga = $new_miga;
		Session::set("adminbc",serialize(self::$miga));
		
	}
	
	static function getIndex($controller,$action,$params, $level = null){
		$return_var = 0;
		if(is_null($level)){
			foreach(self::$miga as $entrada){
				$salir=false;
				if(isset($params['_params'])){
					if(isset($entrada['params']['_params'])){
						if($entrada['controller']==$controller && $entrada['action']==$action) {
							if(is_array($entrada['params'])){
								$disntitos=false;
								foreach($entrada['params'] as $p => $v){
									if($params[$p] == $v)
										continue;
									else{
										$distintos=true;
									}	
								}
								if(!$distintos) $salir=true;
							}
						}elseif($action == "listAction"){
							$salir=true;
						}
					}
				}elseif($entrada['controller']==$controller && $entrada['action']==$action){
					$salir = true;
				}elseif($entrada['controller']!=$controller && $entrada['action']!="defaultAction"){
					$salir=true;
				}
				if($salir){
					break;
				}
				$return_var++;
				
			}
		}else{
			return $level;
		}
		return $return_var;
	}
	
	protected static function getParams($qstring){
		parse_str($qstring, $return_var);
		return $return_var;
	}
	
	static function addBC($title,$level = null){
		self::update(App::getController(),App::getAction(),self::getParams(App::server()->QUERY_STRING),$title,$level);
	}
	
	static function getBC(){
		if(Session::get("adminbc") != ""){
			try{
				self::$miga = unserialize(Session::get("adminbc"));	
			}catch(Exception $e){
				self::$miga = array();
			}
		}else{
			self::$miga = array();
		}
		
		return self::$miga;
	}
}