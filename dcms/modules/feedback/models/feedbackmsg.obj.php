<?php
class Feedback_FeedbackMsg extends D_Core_Object {
	static protected $cacheself = 0;
	public $msgid = 0;
	public $addtime = 0;
	//имя отправителя
	public $name = '';
	//эл. почта
	public $email = '';
	//поле "телефон (факс)"
	public $phone = '';
	//контент
	public $content = '';
	//поле "компания"
	public $company = '';
	//поле "регион"
	public $country_id=0;
	public $countryname='';
	public $region_id = 0;
	public $regname='';
	//поле "город"
	public $city_id =0;
	public $cityname='';
	//поле "департамент"
	public $did =0;
	//поле "причина обращения"
	public $csname = '';
	public $csid=0;
	//активность чекбокса подписка на новости
	public $subscribe = 0;
	//поле "как вы узнали о нас?
	public $rname = '';
	public $rid = 0;
	public $view = 0;
	//public $know = '';

	static protected function __fetch($msgid) {
		return D::$db->fetchobject("SELECT a.*, b.rname, c.csname, e.name AS countryname, f.name AS regname, g.name AS cityname FROM #PX#_feedback_msg a
		LEFT OUTER JOIN #PX#_feedback_know b USING (rid) LEFT OUTER JOIN #PX#_feedback_cause c USING (csid) 
		LEFT OUTER JOIN #PX#_country e USING (country_id)
		LEFT OUTER JOIN #PX#_region f USING (region_id)
		LEFT OUTER JOIN #PX#_city g ON a.city_id=g.city_id WHERE msgid = {$msgid} LIMIT 1",__CLASS__);
	}
	function object_id() {
		return 'conf-'.$this->msgid;
	}
	function delete() {
		D::$db->exec("DELETE FROM #PX#_feedback_msg WHERE msgid = {$this->msgid} LIMIT 1;");
	}
	public function __save() {
		if($this->confid == 0) {
			$this->confid=D::$db->exec("INSERT INTO #PX#_feedback_msg (confid, addtime, name, email, phone, content, company, country_id, region_id, city_id, did, csid, rid, subscribe) 
	VALUES (1, '{$this->addtime}', '{$this->name}','{$this->email}','{$this->phone}','{$this->content}','{$this->company}','{$this->country_id}','{$this->region_id}','{$this->city_id}','{$this->did}','{$this->csid}','{$this->rid}','{$this->subscribe}')");
		} else {
			D::$db->exec("UPDATE #PX#_feedback_msg SET view = '{$this->view}' WHERE msgid= {$this->msgid} LIMIT 1");
		}
		return $this->msgid;
	}
	function getDepartByID() {
		return D::$db->fetchvar("SELECT dep_name FROM #PX#_contacts WHERE did={$this->did}");
	}
	static function __listAll() {
		return D::$db->fetchobjects("SELECT a.*, b.csname FROM #PX#_feedback_msg a LEFT OUTER JOIN #PX#_feedback_cause b USING(csid) ORDER BY addtime",__CLASS__);
	}
	static function getQuestions() {
		return D::$db->fetchobjects("SELECT a.*, b.csname FROM #PX#_feedback_msg a LEFT OUTER JOIN #PX#_feedback_cause b USING(csid) WHERE csid=2 ORDER BY view",__CLASS__);
	}
}
?>