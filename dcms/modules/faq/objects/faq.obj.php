<?php
class Faq extends D_Core_Object {
	static $cacheself = 0;
	//идентификатор вопроса
	public $qid = 0;
	//идентификатор раздела
	public $sid = 0;
	//идентификатор вопроса родителя
	public $pid = 0;
	//формулировка вопроса
	public $qname = '';
	//Содержимое
	public $qcontent = '';
	//количество просмотров
	public $views = 0;
	//рейтинг полезности
	public $rank = 0;

	static function __fetch($qid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_faq WHERE qid = {$qid} LIMIT 1",__CLASS__);
	}
	function object_id() {
		return 'question-'.$this->qid;
	}
	function Delete() {
		D::$db->exec("DELETE FROM #PX#_faq WHERE qid = {$this->qid} LIMIT 1;");
	}
	function __save() {
		if($this->qname=="")
			$this->qname="Новый документ";
		if($this->qid == 0) {
			$this->qid=D::$db->exec("INSERT INTO #PX#_faq (sid, pid, qname, qcontent) VALUES ('{$this->sid}', '{$this->pid}', '{$this->qname}', '{$this->qcontent}')");
		} else {
			D::$db->exec("UPDATE #PX#_faq SET qname = '{$this->qname}',
											  sid = '{$this->sid}',
											  pid = '{$this->pid}',
		    	                              qcontent = '{$this->qcontent}' WHERE qid= {$this->qid} LIMIT 1");
		}
		return $this->qid;
	}
	static function getByQid($qid) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_faq WHERE qid={$qid}",__CLASS__);
	}
	function getChildren() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_faq WHERE pid={$this->qid}",__CLASS__);
	}
	static function CountQuestions($sid){
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_faq WHERE sid={$sid}",__CLASS__);
	}
	static function CountViews($sid){
		return D::$db->fetchvar("SELECT SUM(views) FROM #PX#_faq WHERE sid={$sid}",__CLASS__);
	}
	static function getSections() {
		return D::$db->fetchlines("SELECT * FROM #PX#_faq_section");
	}
	static function __listAll() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_faq",__CLASS__);
	}
}
?>