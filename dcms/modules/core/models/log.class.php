<?php
//!класс логирования событий
class Core_Log extends D_Core_Object {

	const E_WARNING= 'warning';
	const E_ERROR= 'error';
	const E_NOTIFY= 'notify';
	const E_DEBUG= 'debug';

	const T_ADD='add';
	const T_EDIT='edit';
	const T_DELETE='delete';
	const T_REFRESH='refresh';
	const T_OTHER='other';
	const LOG_USER='user';
	const LOG_ADMIN='admin';

	static protected $cacheself = 0;

	public $log_id=0;
	public $log_type='';
	public $log_event='';
	public $manager='';
	public $module;
	public $context='';
	public $add_time;
	public $log_message;
	public $default_module='news';
	private static $instance=null;

	public function __fetch($log_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_logs WHERE log_id = '{$log_id}' ORDER BY add_time",__CLASS__);
	}


	protected function __object_id() {
		return array($this->log_id);
	}

	public static function getInstance(){
		if(self::$instance === null) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	public function addLog($log_type, $log_event, $log_message, $module='') {
		$this->log_type=$log_type;
		$this->log_event=$log_event;
		$this->context=D::getContext();
		if($module) {
			$this->module=$module;
		} else {
			$this->module=$this->default_module;
		}
		$this->log_message=$log_message;
		$this->manager='';
		$this->save();
	}

	public static function getLogs() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_logs ORDER BY add_time",__CLASS__);
	}
	public static function setDefaultLogModule($module) {
		$this->default_module=$module;
	}
	public static function getErrors(){
		return array(self::E_WARNING,self::E_ERROR,self::E_NOTIFY,self::E_DEBUG);
	}

	public static function getEvents(){
		return array(self::T_ADD,self::T_EDIT,self::T_DELETE,self::T_REFRESH,self::T_OTHER);
	}
	public static function getModules(){
		return D::$db->fetchlines("SELECT * FROM #PX#_logs GROUP BY module");
	}
	//сохранение параметров объекта
	public function __save() {
		return D::$db->exec("INSERT INTO #PX#_logs (log_type, log_event, context, module, manager, add_time, log_message)
							 VALUES('{$this->log_type}', '{$this->log_event}', '{$this->context}', '{$this->module}', '{$this->manager}', UNIX_TIMESTAMP(), '{$this->log_message}')",__CLASS__);
	}
	public static function getBySearchCond($search_cond) {
		$fetch_query="SELECT * FROM #PX#_logs ";
		$total_query="SELECT COUNT(1) FROM #PX#_logs ";
		$cond=array();
		if($search_cond["type"]!="")
			$cond[]="log_type='".$search_cond["type"]."'";
		if($search_cond["event"]!="")
			$cond[]="log_event='".$search_cond["event"]."'";
		if($search_cond["context"]!="")
			$cond[]="context='".$search_cond["context"]."'";
		if($search_cond["module"]!="")
			$cond[]="module='".$search_cond["module"]."'";
		if($search_cond["begin_date"]!="") {
			list($day,$month,$year)=explode("/",$search_cond["begin_date"]);
			$cond[]="add_time>=".mktime(0,0,0,$day,$month,$year);
		}
		if($search_cond["end_date"]!="") {
			list($day,$month,$year)=explode("/",$search_cond["end_date"]);
			$cond[]="add_time<=".mktime(0,0,0,$day,$month,$year);
		}
		$logs=new dList();
		$logs->fetch_query = $fetch_query;
		$logs->total_query = $total_query;
		if(count($cond)>0) {
			$logs->fetch_query.="WHERE ".implode(" AND ",$cond);
			$logs->total_query.="WHERE ".implode(" AND ",$cond)." ORDER BY add_time DESC";
		}
		$logs->container = __CLASS__;
		return $logs;
	}
}
?>