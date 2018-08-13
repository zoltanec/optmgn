<?php
class Polls_Category extends D_Core_Object {

	public $name = '';
	public $descr = '';

	protected function __object_id() {
		return array($this->catid);
	}

	static function __fetch($catid = 0 ) {
		return D::$db->fetchobject("SELECT * FROM #PX#_polls_questions_categories WHERE catid = '{$catid}' LIMIT 1",__CLASS__);
	}

	protected function __save() {
		if($this->catid == 0 ) {
			D::$db->exec("INSERT INTO #PX#_polls_questions_categories (name, poll_id) VALUES ('NEW_EMPTY_CATEGORY', '{$this->poll_id}')");
		}
		D::$db->exec("UPDATE #PX#_polls_questions_categories SET name = '{$this->name}', descr = '{$this->descr}' WHERE catid = '{$this->catid}' LIMIT 1");
		return array($this->catid);
	}

	/**
	 * Get list of categories for poll
	 *
	 * @param unknown_type $poll_id
	 */
	static function getPollCategories($poll_id) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_polls_questions_categories WHERE poll_id = '{$poll_id}'",__CLASS__);
	}
}
?>