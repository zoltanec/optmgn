<?php
class Core_I18n_Message extends D_Core_Object {
	public $msg_code = '';
	public $lang = '';
	public $msg_text = '';
	public $javascript = '';
	public $module = '';

	public static $cacheable = 10;

	protected function __object_id() {
		return array($this->msg_code, $this->lang);
	}

	static public function __fetch($msg_code, $lang) {
		return D::$db->fetchobject("SELECT *  FROM #PX#_core_messages WHERE msg_code = '".strtoupper($msg_code)."' AND lang = '{$lang}' LIMIT 1",__CLASS__);
	}

	/**
	 * Get list of messages translated in one language and not updated in another
	 */
	static public function getUntranslatedList($base_lang, $target_lang ) {
		$list = new D_Core_List();
		$list->fetch_query = "SELECT  /*COLS*/ b.msg_code, a.msg_text, '{$target_lang}' AS lang, b.msg_code AS base_msg_code, b.module AS base_module, b.msg_text AS base_msg_text,b.javascript AS base_javascript /*/COLS*/
FROM #PX#_core_messages b
LEFT OUTER JOIN #PX#_core_messages a ON ( a.msg_code = b.msg_code AND a.lang = '{$target_lang}' )
WHERE b.lang = '{$base_lang}'  AND ( a.msg_code = a.msg_text OR a.msg_code IS NULL )";
		$list->container = __CLASS__;
		//echo $list->fetch_query;
		return $list;
	}

	/**
	 * Save language message
	 */
	protected function __save() {
		D::$db->exec("INSERT INTO #PX#_core_messages (msg_code,lang,javascript,msg_text,module) VALUES ('{$this->msg_code}','{$this->lang}','{$this->javascript}','{$this->msg_text}','{$this->module}')
ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text), module = VALUES(module), javascript = VALUES(javascript), upd_time = UNIX_TIMESTAMP()");
		return array($this->msg_code, $this->lang);
	}



	/**
	 * Get list of messages which was updated in only one language
	 */
	static public function getUnupdatedList($base_lang, $target_lang) {
		$list = new D_Core_List();
		$list->fetch_query = "SELECT /*COLS*/ a.msg_text,a.msg_code, b.module AS base_module, b.msg_text AS base_msg_text,b.javascript  /*/COLS*/ FROM #PX#_core_messages a
LEFT OUTER JOIN #PX#_core_messages b ON ( a.msg_code = b.msg_code AND b.lang = '{$base_lang}' )
WHERE a.lang = '{$target_lang}' AND b.upd_time > a.upd_time";
		$list->container = __CLASS__;
		return $list;
	}

	static function getMessagesList($base_lang) {
		$list = new D_Core_List();
		$list->fetch_query = "SELECT /*COLS*/ a.* /*/COLS*/ FROM #PX#_core_messages a WHERE a.lang = '{$base_lang}'";
		$list->container = __CLASS__;
		return $list;
	}

	/**
	 * Delete message from database
	 */
	protected function __delete() {
		D::$db->exec("DELETE FROM #PX#_core_messages WHERE lang = '{$this->lang}' AND msg_code = '{$this->msg_code}' LIMIT 1");
		return array($this->msg_code, $this->lang);
	}
}
?>