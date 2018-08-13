<?php
//комментарии
class Comments_Comment extends D_Core_Object {
    //идентификатор комментария
    public $comid = '';
    //заголовок комментария
    public $title = '';
    //сам комментарий
    public $content = '';
    //время добавления комментария
    public $addtime = 0;
    //время обновления комментария
    public $updtime = 0;
    //автор комментария
    public $username = '';
    //объект комментария
    public $object_id = '';

    static protected $cacheable = array('user' => 0, 'meta' => 0);
    static public $cacheself = 100;

    static function __fetch($comid = 1) {
    	//загружаем комментарий из базы
    	return D::$db->fetchobject("SELECT a.*, b.object_id, c.sign, c.username, c.messages, c.karma, c.avatar, c.gid, c.user_from, d.group_name, d.group_color FROM #PX#_comments_all a LEFT OUTER JOIN #PX#_comments_meta b USING  (object_hash) LEFT OUTER JOIN #PX#_users c USING (uid) LEFT OUTER JOIN #PX#_users_groups d USING (gid) WHERE a.comid = '{$comid}' LIMIT 1", __CLASS__);
    }

    function isModerator() {
    	return in_array($this->uid, array(68654,67306,1864,3177));
    }
    //удаление комментария из баз
    function __delete() {
    	$this->meta->decrementComments();

    	try {
    		$object = $this->meta->object;
    	} catch (Exception $e) {
    		$object = false;
    	}
    	if($object instanceof Comments_Commentable ) {
    		$object->comDec($this->meta);
    	}
        D::$db->exec("DELETE FROM #PX#_comments_all WHERE comid = '{$this->comid}' LIMIT 1");
        return $this->comid;
    }

    function __get_user() {
    	return D_Core_Factory::D_Core_User($this->uid);
    }
    function __get_ip_info() {
    	return array('ip' => long2ip($this->ip));
    }

    /**
     * Обновляем карму
     */
    function UpdateKarma($mode = 'up') {
    	switch ($mode) {
    		case 'up' : $field = 'plus'; break;
    		case 'down': $field = 'minus'; break;
    		default: $field = 'plus';
    	}
    	$this->{$field}++;
    	D::$db->exec("UPDATE #PX#_comments_all SET $field = $field + 1 WHERE comid = '{$this->comid}' LIMIT 1");
    	$this->user->UpdateKarma($mode);
		return $this->plus - $this->minus;
    }

    function __get_comment_karma() {
    	return $this->plus - $this->minus;
    }

    function __get_user_karma() {
    	return $this->karma_plus - $this->karma_minus;
    }


    /**
     * Записываем комментарий в базу
     */
    static function writeComment($input) {
        //узнаем на какой объект у нас комментарий
        $comment = new self();
        //идентификатор объекта
        $comment->object_id = $input['object_id'];
        $comment->content = $input['content'];
        $comment->uid = $input['user']->uid;
        $comment->username = $input['user']->username;

        // загружаем мета информацию об объекте
        // проверяем нужна ли премодерация
		try {
			$meta = D_Core_Factory::Comments_Meta(md5(strtolower($comment->object_id)) );
		} catch( Exception $e) {
			$meta = D_Core_Factory::Comments_Meta(NULL, true, $comment->object_id);
		}

        if($meta->premoderate) {
        	$approved = 0;
        } else {
        	$approved = 1;
        }
	//	$object_path = explode('://', $comment->object_id);
      //  $modulePath = D::getModulePath($object_path[0]);

        $comment->comid = D::$db->exec("INSERT INTO #PX#_comments_all (object_hash, content, add_time, uid, ip, approved) VALUES ('".$meta->object_hash."','{$comment->content}',UNIX_TIMESTAMP(),'{$comment->uid}', INET_ATON('".D::$req->getIP()."'),'{$approved}')");

        try {
        	$obj =  D_Core_Factory::getByID($comment->object_id);
        	if($obj instanceof Comments_Commentable) {
        		$obj->comInc($comment, $meta);
        	}
        } catch (Exception $e) {
        	;
        }
        //меняем количество комментариев
        $meta->incrementComments($comment->comid);
        //добавляем информацию в статистику
        return $comment->comid;
    }

    protected function __get_meta() {
    	return D_Core_Factory::Comments_Meta($this->object_hash);
    }

    function object_hash() {
    	return md5(strtolower($this->object_id));
    }

    protected function __get_updated() {
    	return new dTime($this->updtime);
    }

    protected function __save() {
    	D::$db->exec("UPDATE #PX#_comments_all SET upd_time = UNIX_TIMESTAMP(), content = '{$this->content}', approved = '{$this->approved}', moderator_note = '{$this->moderator_note}' WHERE comid = '{$this->comid}' LIMIT 1");
    	return $this->comid;
    }

    function __precache() {
    	$this->touch('html');
    }
    function __uncache() {
    	//$this->untouch(array('html'), true);
    }
    function __object_id() {
    	return array($this->comid);
    }

    /*возвращаем комментарий в виде HTML кода*/
    protected function __get_html() {
    	return D_Misc_Text::bbParse($this->content);
    }
}
?>