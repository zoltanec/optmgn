<?php
class Polls_Poll  extends D_Core_Object {
	// unique poll identificator
	public $poll_id = 0;
	// poll name
	public $name = 'New poll';
	// activity flag
	public $active = false;
	// sort priority
	public $priority = 0;



	/**
	 * Get needed poll by it poll_id
	 *
	 * @param unknown_type $poll_id
	 */
	static function __fetch($poll_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_polls_list WHERE poll_id = '{$poll_id}' LIMIT 1",__CLASS__);
	}

	/**
	 * Get object id
	 * @return array
	 */
	protected function __object_id() {
		return array($this->poll_id);
	}

	/**
	 * Get polls list
	 *
	 * @return D_Core_List $list - list polls
	 */
	static function getPollsList() {
		$list = new D_Core_List();
		$list->fetch_query = "SELECT a.*, ( SELECT COUNT(1) FROM #PX#_polls_questions b WHERE b.poll_id = a.poll_id AND b.active ) AS questions_count FROM #PX#_polls_list a ORDER BY a.priority ASC";
		$list->container = __CLASS__;
		return $list;
	}

	/**
	 * Statistics for poll
	 */
	protected function __get_stat() {
		// first we need to get count of all questions
		$total_questions = sizeof($this->active_questions);
		//
		$total_tested = D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_polls_answers_for_polls WHERE poll_id = '{$this->poll_id}'");
		$total_full = D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_polls_answers_for_polls WHERE poll_id = '{$this->poll_id}' AND answers >= '{$total_questions}'");
		return array('total_tested' => $total_tested, 'total_full' => $total_full, 'total_unfinished' => $total_tested - $total_full);
	}

	/**
	 * Save poll in database
	 * @see D_Core_Object::save()
	 */
	protected function __save() {
		if($this->poll_id == 0 ) {
			$this->poll_id = D::$db->exec("INSERT INTO #PX#_polls_list (name) VALUES ('New poll')");
			$this->priority = $this->poll_id;
		}
		D::$db->exec("UPDATE #PX#_polls_list SET name = '{$this->name}', active = '{$this->active}', descr = '{$this->descr}', final_message = '{$this->final_message}', priority = '{$this->priority}' WHERE poll_id = '{$this->poll_id}' LIMIT 1");
		return $this->poll_id;
	}

	/**
	 * Get all questions in poll
	 * @return Array $questions - list of all question
	 */
	protected function __get_questions() {
		return Polls_Question::getQuestionsList(array('poll_id' => $this->poll_id));
	}

	/**
	 * Get list of active questions
	 */
	protected function __get_active_questions() {
		return Polls_Question::getQuestionsList(array('poll_id' => $this->poll_id, 'active' => 1));
	}

	/**
	 * get list of available categories
	 */
	protected function __get_categories() {
		return Polls_Category::getPollCategories($this->poll_id);
	}

	/**
	 * Get category info
	 */
	function getCategoryInfo($catid) {
		foreach($this->categories AS $category) {
			if($category->catid == $catid) {
				return $category;
			}
		}
		return new Polls_Category();
	}

	function getCategoryName($catid) {
		$cat = $this->getCategoryInfo($catid);
		return $cat->name;
	}

	/**
	 * Get qids for this poll
	 *
	 */
	protected function __get_qids() {
		$qids = array();
		foreach( $this->questions AS $question ) {
			$qids[] = $question->qid;
		}
		return $qids;
	}


	/**
	 * Delete this poll from database
	 */
	protected function __delete() {
		// delete test
		D::$db->exec("DELETE FROM #PX#_polls_list WHERE poll_id = '{$this->poll_id}' LIMIT 1");
		// delete questions for this poll
		Polls_Question::deleteQuestionsForPoll($this->poll_id);
		return array($this->poll_id);
	}
}
?>
