<?php
class Polls_Useranswer extends D_Core_Object {
	public $aid;
	public $qid = 0;
	public $poll_id = 0;
	public $uid = 0;
	public $answers_list = '';
	public $own_answer = '';
	public $think_time = 0;
	
	public $unique_mode=false;

	/**
	 * Fetch existed user answer from database
	 *
	 * @param int $qid - question id;
	 * @param int $uid - user id;
	 */
	static function __fetch($qid, $uid, $aid=-1) {
		if ( $aid == -1 ) {
			return D::$db->fetchobject("SELECT * FROM #PX#_polls_useranswers WHERE qid = ".intval($qid)." AND uid = ".intval($uid)." LIMIT 1",__CLASS__);
		} else {
			return D::$db->fetchobject("SELECT * FROM #PX#_polls_useranswers WHERE aid = ".intval($aid)." LIMIT 1",__CLASS__);
		}
	}


	/**
	 * Return user answer ID
	 *
	 * @see D_Core_Object::save()
	 * @return array($qid, $uid) - answer for question $qid of $uid user;
	 */
	function __object_id() {
			return array($this->aid,$this->qid, $this->uid);
	}

	/**
	 * Save question answer
	 */
	function __save() {
		
		if ( $this->unique_mode ) {
			
			$this->aid = D::$db->exec("INSERT INTO #PX#_polls_useranswers (qid, poll_id, uid, add_time, think_time, answers_list, own_answer) VALUES ('{$this->qid}', '{$this->poll_id}', '{$this->uid}', UNIX_TIMESTAMP(), '{$this->think_time}', '{$this->answers_list}', '{$this->own_answer}') ON DUPLICATE KEY UPDATE answers_list = '{$this->answers_list}', own_answer = '{$this->own_answer}'");
			
		} else {
		
			$result = D::$db->exec("UPDATE #PX#_polls_useranswers SET answers_list = '{$this->answers_list}', own_answer = '{$this->own_answer}', think_time = '{$this->think_time}', add_time = '{$this->add_time}' WHERE uid = '{$this->uid}' AND qid = '{$this->qid}'");

			//если UPDATE вернул 0 значит записи нету вставляем её.
			
			if ( !$result ) {
				$this->aid = D::$db->exec("INSERT INTO #PX#_polls_useranswers (qid, poll_id, uid, add_time, think_time, answers_list, own_answer) VALUES ('{$this->qid}', '{$this->poll_id}', '{$this->uid}', UNIX_TIMESTAMP(), '{$this->think_time}', '{$this->answers_list}', '{$this->own_answer}') ON DUPLICATE KEY UPDATE answers_list = '{$this->answers_list}', own_answer = '{$this->own_answer}'");
			}
		}
		return array($this->aid,$this->qid, $this->uid);
	}

	/**
	 * Load user answers for specified qids
	 *
	 */
	 static function getUserAnswersForQids($qids, $uid, $mode = 'num') {
	 	if(sizeof($qids) == 0 ) {
			return array();
		}
		$query = "SELECT a.* FROM #PX#_polls_useranswers a LEFT JOIN #PX#_polls_questions b USING (qid) WHERE a.uid = '{$uid}' AND a.qid IN (".implode(',', $qids).") ORDER BY b.priority ASC";
	 	$result = ( $mode == 'clear' ) ? D::$db->fetchlines_clear($query) : D::$db->fetchlines($query);

	 	foreach($result AS &$res) {
			if(!empty($res['own_answer'])) {
				$res['own_answer'] = html_entity_decode($res['own_answer']);
			}
		}
		return $result;
	 }

	 /**
	  * Get count of completed questions for each poll
	  *
	  * @param Array $poll_ids - list of poll_id for polls we need to check
	  * @param int $uid - user id
	  */
	 static function getAnsweredCountForPolls($polls_ids, $uid = 0) {
	 	if(sizeof($polls_ids) == 0 ) return array();
	 	return D::$db->fetchlines_clear("SELECT poll_id, COUNT(1) AS answered FROM #PX#_polls_useranswers WHERE poll_id IN (".implode(',', $polls_ids).") AND uid = '{$uid}' GROUP BY poll_id");
	 }

	 /**
	  * Get list of results
	  */
	 static function getResultsList($poll_id = 0, $filter = array()) {
	 	$cond = array();
	 	if(!empty($filter)) {
	 		if(!empty($filter['city'])) {
	 			$cond[] = "a.user_from LIKE '".$filter['city']."'";
	 		}
	 		if(!empty($filter['age_from']) && is_numeric($filter['age_from'])) {
	 			$cond[] = "DATE(NOW()) - a.birth > {$filter['age_from']}0000";
	 		}
	 		if(!empty($filter['age_to']) && is_numeric($filter['age_to'])) {
	 			$cond[] = "DATE(NOW()) - a.birth < {$filter['age_to']}0000";
	 		}
	 		if($filter['completed'] == 'full') {
	 			$cond[] = "a.answers >= ".intval($filter['questions']);
	 		}
	 		if($filter['completed'] == 'partial') {
	 			$cond[] = "a.answers < ".intval($filter['questions']);
	 		}
	 		if( $filter['sex'] == 'm' ) {
	 			$cond[] = "a.sex = 'm'";
	 		} elseif ($filter['sex'] == 'w') {
	 			$cond[] = "a.sex = 'w'";
	 		}
	 	}
	 	//var_dump($cond);exit;
	 	$cond[] = "a.poll_id = '{$poll_id}'";
	 	
		
	 	return new D_Core_List("SELECT /*COLS*/ a.* /*/COLS*/ FROM #PX#_polls_answers_for_polls a ".D_Db_Query::getWhere($cond));
	 }
	 	 
	 
	 /**
	  * Flush all answers for spicific user
	  */
	 static function flushAnswersForPoll($poll_id = 0, $uid = 0 ) {
	 	D::$db->exec("DELETE FROM #PX#_polls_useranswers WHERE poll_id = ".intval($poll_id)." AND uid = ".intval($uid));
	 }


	 /**
	  * Flush answers for qid
	  */
	 static function flushAnswersForQuestion($qid = 0 ) {
	 	D::$db->exec("DELETE FROM #PX#_polls_useranswers WHERE qid = '{$qid}'");
	 }
}
?>
