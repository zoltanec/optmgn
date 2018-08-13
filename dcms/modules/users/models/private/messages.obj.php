<?php
class Users_Private_Messages extends D_Core_Object {
	use D_Db_ActiveRecord;

	// сообщения чата
	public $msgid = 0;
	// идентификатор чата
	public $chatid_A = 0;
	public $chatid_B = 0;
	//время добавления в секундах
	public $add_time = 0;
	//отправитель
	public $sender = 0;
	//флаги
	public $active_flag = 3;
	public $min_msgid = 0;
	// кэширование
	public static $cacheself = 0;

	function __construct() {
		if($this->add_time == 0) {
			$this->add_time = time();
		}
	}

	static function __pk() {
		return ['msgid'];
	}

	static function __fetch($msgid) {
		return self::__fetch_record($msgid);
	}

	static function Send($uid_from, $uid_to, $message_content) {
		list($chat_owner, $chat_recipient) = Users_Private_Chats::getChats($uid_from, $uid_to, Users_Private_Chats::CREATE_IF_NEEDED);
		$message = new self();
		//записываем новое сообщение
		$chat_owner->last_message = $message_content;
		$chat_recipient->last_message = $message_content;

		$chat_owner->messages++;
		$chat_recipient->messages++;
		$chat_recipient->unread++;

		$message->content = $message_content;
		$message->chatid_A = $chat_owner->chatid;
		$message->chatid_B = $chat_recipient->chatid;
		$message->save();

		$chat_owner->save();
		$chat_recipient->save();
		return true;
	}


	static protected function __getMessagesForChat($chatid, $start_msgid = 0) {
		$list = new D_Db_List();
		// надо ли искать только свежие сообщения
		$search_msgid = ($start_msgid > 0 ) ? 'AND a.msgid > '.intval($start_msgid) : '';

		$list->fetch_query("SELECT /*COLS*/a.*/*/COLS*/ FROM #PX#_users_private_messages a WHERE
		( ( a.chatid_A = '{$chatid}' AND a.active_flag & 1 )  OR ( a.chatid_B = '{$chatid}' AND a.active_flag & 2 ) ) {$search_msgid} ORDER BY msgid ASC");
		$list->container(__CLASS__)->order('reverse');
		return $list;
	}

	function deleteForChat($chatid) {
		if($chatid == $this->chatid_A) {
			if($this->active_flag & 1 ) {
				$this->active_flag -= 1;
			}
		} else {
			if( $this->active_flag & 2 ) {
				$this->active_flag -= 2;
			}
		}
	}

	static function __getLastMessages($uid, $last_msgid = 0) {
		return D::$db->fetchlines("SELECT c.username, c.uid, c.avatar, a.chatid_A, a.chatid_B, a.msgid, a.content FROM #PX#_users_private_messages a
		LEFT OUTER JOIN #PX#_users_private_chats b ON (a.chatid_B = b.chatid)
		LEFT OUTER JOIN #PX#_users c on (c.uid = b.recipient) WHERE b.owner = '{$uid}' AND b.unread > 0 AND a.msgid > '{$last_msgid}' ORDER BY msgid DESC LIMIT 1");
	}


	protected function __save() {
		if($this->msgid == 0) {
			$this->msgid = D::$db->exec("INSERT INTO #PX#_users_private_messages (chatid_A, chatid_B, add_time) VALUES ('{$this->chatid_A}', '{$this->chatid_B}', UNIX_TIMESTAMP() )");
		}
		D::$db->exec("UPDATE #PX#_users_private_messages SET content = '{$this->content}', active_flag = '{$this->active_flag}' WHERE msgid = '{$this->msgid}' LIMIT 1");
		return $this->msgid;
	}
	protected function __delete() {
		D::$db->exec("DELETE FROM #PX#_users_private_messages WHERE msgid = '{$this->msgid}' LIMIT 1");
		return $this->msgid;
	}
}
?>