<?php
//!обработка пользователей
class Users_User extends D_Core_Object {
	const USER_STATUS_ACTIVE = 1;
	const USER_STATUS_INACTIVE = 0;
	const USER_STATUS_BANNED = 2;

	const GROUP_ADMINISTRATORS = 1;
	const GROUP_USERS = 2;

	//!имя пользователя
	public $username = 'Anonymous';
	//!пароль пользователя в MD5
	public $password = '';
	//!идентификатор (UID) пользователя
	public $uid = 0;
	//!is user active
	public $active = 1;
	public $gid = 2;
	//!флаг валидности пользователя
	public $valid = false;
	public $user_from = '';
	public $about = '';

	static public $cacheself = 0;
	static public $cacheable = array('have_pm' => 30);

	//!вложенный класс, подключаемый через основной
	static protected $subclasses = array();

	protected function __object_id() {
		return array($this->uid);
	}

	static function registerUserClass($class, $name = '') {
		$var_name = (empty($name)) ? $class : $name;
		self::$subclasses[strtolower($var_name)] = $class;
	}

	static function __fetch($input_data) {
		if(is_int($input_data)) {
			return D::$db->fetchobject("SELECT * FROM #PX#_users WHERE uid = '{$input_data}' LIMIT 1", __CLASS__);
		} else {
			return D::$db->fetchobject("SELECT * FROM #PX#_users WHERE username = '{$input_data}' LIMIT 1", __CLASS__);
		}
	}

	/**
	 * Check if needed username exists in our database
	 *
	 * @param string $username - username which we need to find
	 * @return bool - if username exists returns true, otherwise false;
	 */
	static function isUsernameExists($username = '') {
		$count = D::$db->fetchvar("SELECT COUNT(1) as count FROM #PX#_users WHERE username = '{$username}'");
		return ($count == 0 ) ? false : true;
	}

	/**
	 * Check if recieved string can be valid username
	 * @param string $username - username we need to check
	 * @return bool - valid or not
	 */
	static function isAllowedUsername($username = '') {
		if(empty($username)) return false;
		return !preg_match('/[^a-zA-Z0-9@\._\-]/', $username);
	}

	function __wakeup() {
		$this->untouch('have_pm');
	}

	function __construct() {
		if($this->uid != 0) {
			$this->uid = (int) $this->uid;
			// now lets save all subclasses for this object
			foreach(self::$subclasses AS $var_name =>$class) {
				$this->{$var_name} = D_Core_Factory::build($class, array($this->uid));
			}
		}
	}

	function __flush() {
		return $this->uid;
	}

	/**
	 * Before caching procedure
	 */
	function __precache() {
	}


	function messagesIncr() {
		D::$db->exec("UPDATE #PX#_users SET messages = messages + 1 WHERE uid = '{$this->uid}' LIMIT 1");
		//каждые 100 сообщений увеличиваем карму
		if( ( $this->messages % 100 ) == 0) {
			$this->UpdateKarma('up');
		}
	}

	function __save() {
		if($this->uid == 0 ) {
			 $this->uid = D::$db->exec("INSERT INTO #PX#_users (username, password, gid, reg_time, karma, active, confirm_code) VALUES ('{$this->username}','{$this->password}',{$this->gid},UNIX_TIMESTAMP(), 0, '{$this->active}', '{$this->confirm_code}')");
		}
		D::$db->exec("UPDATE #PX#_users SET avatar = '{$this->avatar}',
											 about = '{$this->about}',
											 active = '{$this->active}',
											 birth = '{$this->birth}',
											 username = '{$this->username}',
											   sex = '{$this->sex}',
										  password = '{$this->password}',
											  sign = '{$this->sign}',
											   gid = '{$this->gid}',
									   active_from = '{$this->active_from}',
										 user_from = '{$this->user_from}',
										 interests = '{$this->interests}'
										 WHERE uid = '{$this->uid}' LIMIT 1");
		return $this->uid;
	}

	function setPassword($newpassword) {
		$this->password = md5($newpassword);
		return true;
	}

	/**
	 * Получаем список пользовательских предупреждений
	 */
	function getUserWarningsList() {
		// отдаем список сделанных предупреждений пользователю
		return D::$db->fetchlines("SELECT * FROM #PX#_users_warnings WHERE uid = '{$this->uid}' ORDER BY wid DESC");
	}

	/**
	 * Удалить предупреждение выданное пользователю
	 */
	function deleteUserWarning($wid) {
		D::$db->exec("DELETE FROM #PX#_users_warnings WHERE wid = '{$wid}' AND uid = '{$this->uid}' LIMIT 1");
	}

	/**
	 * Добавить предупреждение пользователю
	 */
	function addUserWarning($msg = '') {
		return D::$db->exec("INSERT INTO #PX#_users_warnings (msg,uid,add_time) VALUES ('{$msg}', '{$this->uid}',UNIX_TIMESTAMP())");
	}
	function getUserWarning($wid) {
		return D::$db->fetchline("SELECT * FROM #PX#_users_warnings WHERE uid = '{$this->uid}' AND wid = '{$wid}' LIMIT 1");
	}
	/**
	 * Устанавливаем пользователю бан
	 */
	function setBan($days = 0) {
		// устанавливаем время разблокировки пользователя
		$days = floatval($days);
		D::$db->exec("UPDATE #PX#_users SET active_from = UNIX_TIMESTAMP() + ".(86400 * $days)." WHERE uid = '{$this->uid}' LIMIT 1");
		$this->flush();
		return false;
	}
	function setUnBan() {
		$this->active = 1;
		$this->active_from = 0;
	}

	function isActive() {
		if($this->active == 0 || ( $this->active_from !=0 && $this->active_from > time() )) {
			return false;
		} else {
			return true;
		}
	}

	protected function __get_final($name) {
		if(isset(self::$subclasses[$name])) {
			$this->{$name} = D_Core_Factory::build(self::$subclasses[$name], array($this->uid));
			return $this->{$name};
		}
	}

	function __get_have_pm() {
		D::appendModuleNamespace('users');
		$pm = Users_Private_Chats::getUnreadMessagesCount($this->uid);
		return (empty($pm)) ? 0 : $pm;
	}

	function KarmingAvailable() {
		if($this->karma_update < time() - 3600) {
			return true;
		}
	}

	function VoteKarma() {
		$this->karma_update = time();
		//D::$db->exec("UPDATE #PX#_users SET karma_update = UNIX_TIMESTAMP() WHERE uid = '{$this->uid}' LIMIT 1");
	}

	function UpdateKarma($mode = 'up') {
		switch($mode) {
			case 'up': $update = ' + 1'; $field = 'karma_plus'; break;
			case 'down': $update = ' -1'; $field = 'karma_minus'; break;
			default: $update = '+1'; $field = 'karma_plus';
		}
		//D::$db->exec("UPDATE #PX#_users SET karma = karma $update, $field = $field + 1 WHERE uid = '{$this->uid}' LIMIT 1");
	}

	function KarmaSetter() {
	//	D::$db->exec("UPDATE #PX#_users SET karma_update = UNIX_TIMESTAMP() WHERE uid = '{$this->uid}' LIMIT 1");
	}

	static function getUsersList($options = array()) {
		$conditions = array();
		$list = new D_Core_List();
		if(sizeof($options) > 0 ) {
			if(isset($options['mode']) && $options['mode'] == 'banned' ) {
				$conditions[] = "not active";
			}
			if(isset($options['gid'])) {
				$conditions[] = $options['gid'];
			}
		}
		if(sizeof($conditions) > 0 ) {
			$where = " WHERE ".implode(' AND ', $conditions);
		} else {
			$where = '';
		}
		$list->fetch_query = "SELECT /*COLS*/*/*/COLS*/ FROM #PX#_users {$where} ORDER BY uid ASC";
		$list->container = __CLASS__;
		$list->order = 'normal';
		return $list;
	}
	/**
	 * Получаем пользовательскую сессию юзера
	 */
	static function getSessionUser() {

		@session_start();
		if(isset($_SESSION['requests'])) {
			$_SESSION['requests'] = $_SESSION['requests'] + 1;
		} else {
			$_SESSION['requests'] = 1;
		}
	   	if(isset($_SESSION[D::$config->users_session_var]) AND is_object($_SESSION[D::$config->users_session_var]) AND $_SESSION[D::$config->users_session_var]->valid) {
		   return $_SESSION[D::$config->users_session_var];
		//если пользователя мы запомнили по кукисам
		} elseif(D::$config->long_cookie_sessions AND isset($_COOKIE[D::$config->users_cookie_name]) and $_COOKIE[D::$config->users_cookie_name] != 'EMPTY') {
			$cookie_session = preg_replace('/[^a-zA-Z0-9]/','a', $_COOKIE[D::$config->users_cookie_name]);
			//загружаем информацию из базы
			$data = D::$db->fetchline("SELECT * FROM #PX#_users_cookies WHERE cookie_session = '{$cookie_session}' LIMIT 1");
			//если мы нашли пользователя
			if(!empty($data)) {
				try {
					$user = D_Core_Factory::Users_User( intval( $data['uid']));
					$user->valid = 1;
					$_SESSION[D::$config->users_session_var] = $user;
					D::$online_stat->authorized($_SESSION[D::$config->users_session_var]->uid);
					//похоже пользователь такой есть..ну тогда обновим сессию.чтоб не удалило ее
					D::$db->exec("UPDATE #PX#_users_cookies SET lastaccess = NOW() WHERE cookie_session = '{$cookie_session}' LIMIT 1");
					return $_SESSION[D::$config->users_session_var];
				} catch ( Exception $e) {
					return false;
				}
			} else {
				self::logout();
			}
		}
	}

	/**
	 * Запомнить пользователя надолго, сохранить сессию в куках и записать в базу
	 */
	function RememberMe() {
		//генерируем пользовательскую сессию
		$cookie_session = md5(time().$this->username.rand());
		//хэш браузера
		$browser = md5($_SERVER['HTTP_USER_AGENT']);
		setcookie(D::$config->users_cookie_name, $cookie_session, time() + 86400 * 30,"/");
		D::$db->exec("INSERT INTO #PX#_users_cookies (cookie_session, uid, browser) VALUES ('{$cookie_session}','{$this->uid}','{$browser}')
		ON DUPLICATE KEY UPDATE cookie_session  = '{$cookie_session}'");
	}

	/**
	 * Снимаем авторизацию
	 */
	function logout() {
		$this->valid = false;
		if(isset($_COOKIE[D::$config->users_cookie_name])) {
			$cookie_session = preg_replace('/[^a-zA-Z0-9]/','a', $_COOKIE[D::$config->users_cookie_name]);
			D::$db->exec("DELETE FROM #PX#_users_cookies WHERE cookie_session = '{$cookie_session}' LIMIT 1");
			if(rand(1,100) == 50) {
				D::$db->exec("DELETE FROM #PX#_users_cookies WHERE lastaccess < ADDDATE(NOW(),-30)");
			}
		}
		//теперь ставим левый кукис
		setcookie(D::$config->users_cookie_name,'EMPTY',time(),"/");
	}

	function authorize($password) {
		if($this->active != self::USER_STATUS_ACTIVE) {
			return false;
		}
		//проводим авторизацию
		if(!empty($this->password)) {
			return (md5($password) === $this->password);
		} else {
			return false;
		}
	}


	function reqRights($permission = '') {
		if( $this->gid == self::GROUP_ADMINISTRATORS ) {
			return true;
		}
		$moders = array(68654,67306,1864,3177,71250);
		if(in_array($this->uid,$moders)) {
			return true;
		} else {
			return false;
		}
	}
}
?>