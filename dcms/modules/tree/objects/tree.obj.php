<?php
class Tree extends dObject {

	//идентификатор документа
	public $did = 0;
	//идентификатор документа родителя
	public $pid = 0;
	//название документа
	public $dname = 'None';
	//Содержимое
	public $dcontent = '';
	public $priority = 0;
	static $preview_length = 300;
	
	static protected function __fetch($did) {
		return D::$db->fetchobject("SELECT * FROM #PX#_tree WHERE did = {$did} LIMIT 1",__CLASS__);
	}
	function object_id() {
		return 'document-'.$this->did;
	}
    function __get_shortname() {
    	if(strlen($this->dname)<=self::$preview_length) {		
    		$short = $this->dname;
    	}else {
    		$short = substr($this->dname,0,strpos($this->dname,' ', self::$preview_length));
    		$short.='...';
    	}
        $short = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags($short));
        $short = mb_strtoupper(substr($short,0,2)).mb_strtolower(substr($short,1));
        return $short;
    }
	function Delete() {
		D::$db->exec("DELETE FROM #PX#_tree WHERE did = {$this->did} LIMIT 1;");
	}
	function __save() {
		if($this->dname=="")
			$this->dname="Новый документ";
		if($this->did == 0) {
			$this->did=D::$db->exec("INSERT INTO #PX#_tree (pid, dname, dcontent, priority) VALUES ('{$this->pid}', '{$this->dname}', '{$this->dcontent}', '{$this->priority}')");
		} else {
			D::$db->exec("UPDATE #PX#_tree SET dname = '{$this->dname}',
											   pid = '{$this->pid}',
		    	                               dcontent = '{$this->dcontent}',
		    	                               priority = '{$this->priority}' WHERE did={$this->did} LIMIT 1");
		}
		return $this->did;
	}
	function getChildren() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_tree WHERE pid={$this->did} ORDER BY priority DESC",__CLASS__);
	}
	static function __listAll() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_tree ORDER BY priority DESC",__CLASS__);
	}
	static function getByPid($pid) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_tree WHERE pid={$pid} ORDER BY priority DESC",__CLASS__);
	}
	function getFirst() {
		return D::$db->fetchobject("SELECT * FROM #PX#_tree WHERE pid={$this->did} ORDER BY priority DESC LIMIT 1",__CLASS__);
	}
}
?>