<?php
//объект чата пользователя
class Chat extends D_Core_Object {
	static public $cacheself = 10;
	// идентификатор комнаты чата
	public $rid = 1;

	const CHAT_EVENT_JOIN = 3;
	const CHAT_EVENT_EXIT = 4;
	const CHAT_EVENT_CHANGE_COLOR = 5;
	const CHAT_EVENT_DELETE = 6;

	static function __fetch($chatroom) {
		return new self();
	}
	function __save() {
		return false;
	}
	function object_id() {

	}

	function send($uid_from,$uid_to,$message,$type = 1) {
		if(is_array($message)) {
			$message = implode(';;;', $message);
		}
		$msgid = D::$db->exec("INSERT INTO #PX#_chat_messages (uid, add_time,message,type) VALUES ('{$uid_from}',UNIX_TIMESTAMP(),'{$message}','{$type}')");
		return $msgid;
	}

	function read($uid, $last_msgid) {
		// обновляем статистику о времени последнего доступа
		D::$db->exec("UPDATE #PX#_chat_users SET upd_time = UNIX_TIMESTAMP() WHERE uid = '{$uid}'");
		if(rand(0,100) < 5) {
			D::$db->exec("DELETE FROM #PX#_chat_messages WHERE add_time < UNIX_TIMESTAMP() - 1200");
			D::$db->exec("DELETE FROM #PX#_chat_users WHERE upd_time < UNIX_TIMESTAMP() - 600");
		}
		if($last_msgid > 0 ) {
			return D::$db->fetchlines("SELECT * FROM #PX#_chat_messages WHERE uid != '{$uid}' AND msgid > '{$last_msgid}' ORDER BY msgid ASC");
		} else {
			return D::$db->fetchlines("SELECT * FROM #PX#_chat_messages ORDER BY msgid ASC");
		}
	}

	function enter($user) {
		if($user->uid == 0) {
			echo "no";exit;
		}
		$colors = self::getColorsList();
		$color = round(rand(0, sizeof($colors)));
		if(!isset($this->users[$user->uid])) {
			// отсылаем сообщение что пользователь зашел в чат
			$this->send($user->uid, 0,array($user->username, $user->avatar,'NO_STATUS',$color), 3);
		}
		// пользователь входит в чат
		D::$db->exec("INSERT INTO #PX#_chat_users (add_time,uid,rim,avatar,visible_name,color)
		 VALUES (UNIX_TIMESTAMP(), '{$user->uid}', '{$this->rim}','{$user->avatar}','{$user->username}','{$color}')
		 ON DUPLICATE KEY UPDATE upd_time = UNIX_TIMESTAMP()");
	}

	function user_exit($user) {
		$this->send($user->uid, 0, '', 4);
		D::$db->exec("DELETE FROM  #PX#_chat_users WHERE uid = '{$user->uid}'");
	}

	protected function __get_users() {
		return D::$db->fetchlines_clear("SELECT uid, avatar, visible_name,color FROM #PX#_chat_users WHERE rim = '{$this->rim}'");
	}

	function setUserColor($uid, $color) {
		$colors = $this->getColorsList();
		if(isset($colors[$color])) {
			$this->send($uid, 0, array($color, $this->users[$uid]['color']), self::CHAT_EVENT_CHANGE_COLOR);
			D::$db->exec("UPDATE #PX#_chat_users SET color = '{$color}' WHERE uid = '{$uid}'");
		}
	}

	/**
	 * Получаем сообщение по его идентификатору
	 *
	 * @param unknown_type $msgid
	 */
	function getMessage($msgid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_chat_messages WHERE msgid = '{$msgid}' LIMIT 1");
	}

	/**
	 * Удаление сообщения из базы
	 */
	function deleteMessage($msg) {
		$this->send($msg->uid,0,$msg->msgid,self::CHAT_EVENT_DELETE);
		D::$db->exec("DELETE FROM #PX#_chat_messages WHERE msgid = '{$msg->msgid}' LIMIT 1");
	}

	/**
	 * Создаем палитру цветов с максимальным количеством цветов от $palete_size
	 *
	 * @param unknown_type $palete_size
	 */
	function getColorsList( $palete_size = 90) {
		$colors =array();
		$get_hex = function($num) {
			if(strlen(dechex($num)) < 2) {
				$color = '0'.dechex($num);
			} else {
				$color = dechex($num);
			}
			return $color;
		};
		$gradations = array(0, 102, 204, 255);
		foreach($gradations AS $red_num) {
			$red = $get_hex($red_num);
			foreach($gradations AS $green_num) {
				$green = $get_hex($green_num);
				foreach($gradations AS $blue_num) {
				$blue = $get_hex($blue_num);
					$colors[] = $red.$green.$blue;
				}
			}
		}
		return $colors;
	}
}
?>