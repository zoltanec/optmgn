<?php
class Users_Private_Chats extends D_Core_Object {
	use D_Db_ActiveRecord;

	const CREATE_IF_NEEDED = 1;
	//идентификатор чата
	public $chatid = 0;
	//владелец чата
	public $owner = 0;
	//получатель чата
	public $recipient = 0;
	//последнее сообщение чата
	public $last_message = 0;

	public $mesages = 1;

	public $upd_time = 0;

	private $min_msgid = 0;

	static public $cacheself = 10;
	//public $cacheable = array('messages_list' => 0);

	static function __fetch($chatid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_users_private_chats WHERE chatid = '{$chatid}' LIMIT 1",__CLASS__);
	}

	static function __pk() {
		return ['chatid'];
	}

	static protected function __getUnreadMessagesCount($uid = 0) {
		return D::$db->fetchvar("SELECT SUM(unread) AS unreaded FROM #PX#_users_private_chats WHERE owner = '{$uid}'");
	}

	static protected function __getChatsList($uid) {
		$list = new D_Core_List( "SELECT /*COLS*/a.*,b.username,b.avatar/*/COLS*/ FROM #PX#_users_private_chats a
		                     LEFT OUTER JOIN #PX#_users b ON (a.recipient = b.uid )
		                     WHERE owner = '{$uid}' ORDER BY unread DESC, upd_time DESC");
		$list->container = __CLASS__;
		return $list;
	}

	static protected function __getChatForRecepient($owner_uid, $recipient_uid) {
		return D::$db->fetchobject("SELECT a.* FROM #PX#_users_private_chats a WHERE owner = '{$owner_uid}' AND recipient = '{$recipient_uid}' LIMIT 1",__CLASS__);
	}

	static protected function __getChats($owner_uid, $recipient_uid, $flags = 0) {
		$chats = D::$db->fetchlines("SELECT chatid,owner, recipient FROM #PX#_users_private_chats WHERE ( owner = '{$owner_uid}' AND recipient = '{$recipient_uid}' )
		                                                                                             OR ( owner = '{$recipient_uid}' AND recipient = '{$owner_uid}')");

		if(sizeof($chats) < 2 ) {
			$owner_chat = new self();
			$recipient_chat = new self();
			$owner_chat->owner($owner_uid)->recipient($recipient_uid);
			$recipient_chat->owner($recipient_uid)->recipient($owner_uid);
			if($flags & self::CREATE_IF_NEEDED) {
				$owner_chat->save();
				$recipient_chat->save();
			}
		} else {
			foreach($chats AS $chat) {
				if($chat['owner'] == $owner_uid) {
					$owner_chat = D_Core_Factory::Users_Private_Chats($chat['chatid']);
				} else {
					$recipient_chat = D_Core_Factory::Users_Private_Chats($chat['chatid']);
				}
			}
		}
		return array($owner_chat, $recipient_chat);
	}

	public function setChatReaded() {
		D::$db->exec("UPDATE #PX#_users_private_chats SET unread = 0 WHERE owner = '{$this->owner}' AND recipient = '{$this->recipient}' LIMIT 1");
	}

	static function __getMyChats($uid) {
		return D::$db->fetchobjects("SELECT a.*,b.username,b.avatar FROM #PX#_users_private_chats a LEFT OUTER JOIN #PX#_users b ON (b.uid = a.recipient) WHERE a.owner = '{$uid}'");
	}

	protected function __save() {
		if($this->chatid == 0 ) {
			$this->chatid = D::$db->exec("INSERT INTO #PX#_users_private_chats (owner, recipient) VALUES ('{$this->owner}', '{$this->recipient}')");
		}
		D::$db->exec("UPDATE #PX#_users_private_chats SET last_message = '{$this->last_message}',
		                                                      messages = '{$this->messages}',
		                                                      unread = '{$this->unread}',
		                                                      upd_time = UNIX_TIMESTAMP(),
		                                                      outgoing = '{$this->outgoing}' WHERE chatid = '{$this->chatid}' LIMIT 1");
		return $this->chatid;
	}

	/**
	 * Проверяем относится ли пользователь к нашему чату
	 *
	 * @param int $uid - идентификатор проверяемого пользователя
	 */
	function inChat($uid) {
		return ($this->owner == $uid || $this->recipient == $uid ) ? true : false;
	}

	function setMinMsgid($msgid = 0) {
		$this->min_msgid = $msgid;
	}
	protected function __get_messages_list() {
		return Users_Private_Messages::getMessagesForChat($this->chatid, $this->min_msgid);
	}
}
?>