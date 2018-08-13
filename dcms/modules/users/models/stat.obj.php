<?php
//класс для получения и сохранения статистики о пользователях в онлайне
class Users_Stat extends D_Core_Object {
    static protected $cacheable = array('stat'=>180);

    static protected $cachestatic = array('WhoIsOnline' => 3);

    protected $last_object_id = '';
    const ONLINE_MAX_USERS = 30;
    //описываем кэшированные переменные
    function authorized($uid = 0) {
        //пользователь авторизовался. указываем статистике что надо обновить инфу
        D::$db->exec("INSERT INTO #PX#_users_sessions (session_id,uid,ip,first) VALUES ('".session_id()."','{$uid}',INET_ATON('{$_SERVER['REMOTE_ADDR']}'),UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE uid = '{$uid}'");
    }

    function setObjectId($object_id) {
    	$this->last_object_id = $object_id;
    }

    function TraceMe() {
    	$object_hash = ($this->last_object_id != '') ? md5(strtolower($this->last_object_id)) : '';
        if( !isset($_SESSION['last_session_update'])
                OR  $_SESSION['last_session_update'] < time() - 300
                OR  $_SESSION['last_module'] != D::$currentModule ) {
			if(D::$user) {
            	$uid = D::$user->uid;
			} else {
				$uid = 0;
			}
            //инфы о пользователе нет
            D::$db->exec("INSERT INTO #PX#_users_sessions (session_id,ip,first,module,uid,object_hash)
            VALUES ('".session_id()."',INET_ATON('".$_SERVER['REMOTE_ADDR']."'),UNIX_TIMESTAMP(),'".D::$currentModule."','{$uid}','{$object_hash}')
            ON DUPLICATE KEY UPDATE last = NOW(), module = '".D::$currentModule."', object_hash = '{$object_hash}', uid = '{$uid}'");
            $_SESSION['last_session_update'] = time();
            $_SESSION['last_module'] = D::$currentModule;
        }
    }


    //статистика сайта
    function __get_stat() {
        $stat = D::$db->fetchline("SELECT (SELECT COUNT(1) FROM #PX#_users_sessions) AS total,(SELECT COUNT(1) FROM #PX#_users_sessions WHERE uid !=0) AS authorized");
        $stat['guests'] = $stat['total'] - $stat['authorized'];
        //удаляем старые сессии
        D::$db->exec("DELETE FROM #PX#_users_sessions WHERE UNIX_TIMESTAMP(last) < UNIX_TIMESTAMP() - 300");
        return $stat;
    }

    /**
     * Регистрация модуля в шаблонизаторе Smarty
     *  ...
     * @param Smarty $smarty - экземпляр шаблонизатора smarty;
     */
    function register($smarty) {
    	$smarty->assignByRef('onlinestat', $this);
    }

    function LogIP() {
    	$ip = ip2long($_SERVER['REMOTE_ADDR']);
    	D::$db->exec("INSERT INTO #PX#_ip_log (act_date, ip) VALUES (NOW(), '$ip') ON DUPLICATE KEY UPDATE pages = pages + 1");
    }

    static protected function __WhoIsOnline($module, $object_id = '') {
		$object_hash_search = ($object_id != '') ? ' OR a.object_hash = "'.md5(strtolower($object_id)).'"' : '';
    	$guests = D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_users_sessions a WHERE ( a.module = '{$module}' {$object_hash_search} ) and a.uid = 0");
    	$users = D::$db->fetchlines("SELECT a.uid,b.username FROM #PX#_users_sessions a
    	LEFT OUTER JOIN #PX#_users b USING (uid)
    	WHERE ( a.module = '{$module}' {$object_hash_search}) and a.uid != 0 ORDER BY a.last LIMIT ".self::ONLINE_MAX_USERS);
    	return array('users' => $users, 'guests' => $guests);
    }
    //заглушки
    protected function __save() {
    	return false;
    }
    protected static function __fetch($id) {
    	return false;
    }
    protected function __object_id() {
    	return array('all');
    }
}
?>