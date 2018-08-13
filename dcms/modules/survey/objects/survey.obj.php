<?php
class Survey extends dObject {
	
	static function __fetch($survey_id) {
		return D::$db->fetchobject("SELECT ");
	}
	
	/**
	 * Идентификатор объекта
	 */
	function object_id() {
		return 'survey-survey-'.$this->survey_id;
	}

}
?>