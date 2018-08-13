<?php
class Polls_Question extends D_Core_Object {
	public $qid = 0;
	//poll id
	public $poll_id = 0;
	// подсказка для пользователя
	public $help  = '';
	public $catid = 0;
	/**
	 * Get question object by it
	 *
	 * @param int $qid - question unique ID
	 */
	static function __fetch($qid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_polls_questions WHERE qid = '{$qid}' LIMIT 1",__CLASS__);
	}

	/**
	 * Get poll for this question
	 */
	protected function __get_poll() {
		return D_Core_Factory::Polls_Poll($this->poll_id);
	}

	/**
	 * Get this object id
	 */
	protected function __object_id() {
		return array($this->qid);
	}

	/**
	 * Save question object
	 *
	 * @return int $qid - question id
	 */
	protected function __save() {
		if($this->qid == 0 ) {
			$this->qid = D::$db->exec("INSERT INTO #PX#_polls_questions (question, poll_id) VALUES ('NONE', '{$this->poll_id}')");
		}
		D::$db->exec("UPDATE #PX#_polls_questions SET question = '{$this->question}', catid = '{$this->catid}', active = '{$this->active}', priority = '{$this->priority}', mode = '{$this->mode}', answers = '{$this->answers}', help = '{$this->help}' WHERE qid = '{$this->qid}' LIMIT 1");
	}

	/**
	 * Available modes list
	 */
	static function getQuestionModes() {
		return array(0 => 'POLLS_QUESTION_MODE_MANUAL_ENTER',
					 1 => 'POLLS_QUESTION_MODE_SINGLE_ANSWER',
					 2 => 'POLLS_QUESTION_MODE_ONE_OR_MANY',
		             3 => 'POLLS_QUESTION_MODE_ONE_OR_MANY_OR_MANUAL',
					 4 => 'POLLS_QUESTION_MODE_ONE_OR_MANY_AND_MANUAL');
	}

	static function getQuestionModeName($mode) {
		$modes = self::getQuestionModes();
		return $modes[$mode];
	}

	/**
	 * Get list of question answers
	 *
	 * @return Array - answerslist
	 */
	public function getAnswers() {
		// if answers is empty returns empty array
		return (empty($this->answers)) ? array() : explode("\n", $this->answers);
	}

	/**
	 * Get list of questions
	 * @param Array $options - some options to select needed questions
	 *
	 * @return Array $questions - list of founded questions
	 */
	static protected function __getQuestionsList($options = Array()) {
		$conditions = array();
		$list = new D_Db_List();
		$list->fetch_query = "SELECT a.* FROM #PX#_polls_questions a";
		if(isset($options['poll_id'])) {
			$conditions[] = "a.poll_id = ".intval($options['poll_id']);
		}
		if(isset($options['active'])) {
			$conditions[] = "a.active";
		}
		$list->container = __CLASS__;
		$list->fetch_query = "SELECT a.* FROM #PX#_polls_questions a ".D_Db_Query::getWhere($conditions)." ORDER BY a.priority ASC";
		return $list;
	}

	protected function __delete() {
		D::$db->exec("DELETE FROM #PX#_polls_questions WHERE qid = '{$this->qid}' LIMIT 1");
	}

	static public function deleteQuestionsForPoll($poll_id) {
		D::$db->exec("DELETE FROM #PX#_polls_questions WHERE poll_id = '{$poll_id}'");
		D::$db->exec("DELETE FROM #PX#_polls_useranswers WHERE poll_id = '{$poll_id}'");
	}
}
?>
