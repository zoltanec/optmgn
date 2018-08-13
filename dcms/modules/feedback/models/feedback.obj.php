<?php
class Feedback_Feedback extends D_Core_Object {
	//Время полного кеширования объекта
	static public $cacheself = 0;
	//идентификатор конфига
	public $confid= 1;
	//активность поля "телефон (факс)"
	public $phone = 0;
	//активность поля "компания"
	public $company = 0;
	//активность поля "компания"
	public $region = 0;
	//активность поля "город"
	public $country = 0;
	//активность поля "департамент"
	public $depart = 0;
	//активность поля "причина обращения"
	public $cause = 0;
	//активность чекбокса подписка на новости
	public $subscribe = 0;
	//активность поля "как вы узнали о нас?
	public $know = 0;

	static public function __fetch($confid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_feedback WHERE confid = '{$confid}' LIMIT 1",__CLASS__);
	}
	function __object_id() {
		return  array($this->confid);
	}
	function Delete() {
		D::$db->exec("DELETE FROM #PX#_feedback WHERE confid = {$this->confid} LIMIT 1;");
	}
	function __save() {
		if($this->confid==0) {
			$this->confid=D::$db->exec("INSERT INTO #PX#_feedback (phone, company, region, country, depart, cause, subscribe, know)
			VALUES ('{$this->phone}', '{$this->company}', '{$this->region}', '{$this->country}', '{$this->depart}', '{$this->cause}', '{$this->subscribe}', '{$this->know}')");
		} else {
			D::$db->exec("UPDATE #PX#_feedback SET phone = '{$this->phone}',
											  company = '{$this->company}',
											  region = '{$this->region}',
		    	                              country = '{$this->country}',
		    	                              depart = '{$this->depart}',
		    	                              cause = '{$this->cause}',
		    	                              subscribe = '{$this->subscribe}',
		    	                              know = '{$this->know}' WHERE confid= {$this->confid} LIMIT 1");
		}
		return $this->confid;
	}
	function getCauses() {
		return D::$db->fetchlines("SELECT * FROM #PX#_feedback_cause WHERE confid={$this->confid}");
	}
    static function deleteCause($csid) {
		return D::$db->exec("DELETE FROM #PX#_feedback_cause WHERE csid={$csid}");
	}
	function saveCause($csname,$csid) {
		if($csid == 0) {
			D::$db->exec("INSERT INTO #PX#_feedback_cause (csname, confid) VALUES ('{$csname}', '{$this->confid}')");
		} else {
			return D::$db->exec("UPDATE #PX#_feedback_cause SET csname='{$csname}' WHERE csid={$csid}");
		}
	}
	function getReply() {
		return D::$db->fetchlines("SELECT * FROM #PX#_feedback_know WHERE confid={$this->confid}");
	}
    static function deleteReply($rid) {
		return D::$db->exec("DELETE FROM #PX#_feedback_know WHERE rid={$rid}");
	}
	function saveReply($rname,$rid) {
		if($rid == '') {
			D::$db->exec("INSERT INTO #PX#_feedback_know (rname, confid) VALUES ('{$rname}', '{$this->confid}')");
		} else {
			return D::$db->exec("UPDATE #PX#_feedback_know SET rname='{$rname}' WHERE rid={$rid}");
		}
	}
	static function __listConfs() {
		return D::$db->fetchlines("SELECT confname FROM #PX#__feedback");
	}
	static function getRegions() {
			return D::$db->fetchlines("SELECT * FROM #PX#_region where country_id=3159");
	}
	static function getCountries() {
			return D::$db->fetchlines("SELECT * FROM #PX#_country");
	}
	static function getDeparts() {
		if(D::getModulePath('contacts')) {
				return D::$db->fetchlines("SELECT * FROM #PX#_contacts");
		}
	}
}
?>