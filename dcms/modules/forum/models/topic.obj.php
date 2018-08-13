<?php

class Forum_Topic extends D_Core_Object {

	//количество сообщений отображаемых на странице
	const FORUM_MESSAGES_ON_PAGE = 30;
	//максимальное количество топиков на странице
	const FORUM_TOPICS_ON_PAGE = 30;
	//максимальной количество страниц отображемых в листалке
	const FORUM_MAX_PAGER = 6;


	static protected $cacheable = array('content' => 100,'user' => 0);
	static protected $cachestatic = array('Topic'=> 2);
	static public $cacheself = 1;

	public $tid = 0;

	static public function __fetch($tid) {
    	 return D::$db->fetchobject("SELECT a.* FROM #PX#_forum_topics a WHERE a.tid = '$tid' LIMIT 1",__CLASS__);
    }

    function __get_content() {
    	return D::$db->fetchvar("SELECT content FROM #PX#_forum_topics_content WHERE tid = '{$this->tid}' LIMIT 1");
    }

    function __set_content($content) {
    	D::$db->exec("INSERT INTO #PX#_forum_topics_content (tid, content) VALUES ('{$this->tid}', '{$content}') ON DUPLICATE KEY UPDATE content = '{$content}'");
    	$this->untouch('content', true);
    }

    function __get_user() {
    	return D_Core_Factory::Users_User(intval($this->uid));
    }

    function __get_html() {
    	return D_Misc_Text::bbParse($this->content);
    }
    function __precache() {
    	$this->touch(array('content','html','user'));
    }

    function isNeedPager() {
    	return ($this->messages > self::FORUM_MESSAGES_ON_PAGE) ? true : false;
    }
    function __get_pages() {
    	return ceil( ($this->messages - 1) / self::FORUM_MESSAGES_ON_PAGE);
    }

    function getPager() {
    	if($this->pages > self::FORUM_MAX_PAGER ) {
    		return array_merge(array('1','2', 0), range($this->pages - 2, $this->pages));
    	} else {
    		return range(1,$this->pages);
    	}
    }

    /**
     * Возвращаем объект секции в которой расположен наш топик
     */
    function __get_section() {
    	return D_Core_Factory::Forum_Section($this->sid);
    }

    /**
     * Статистика темы
     */
    protected function __get_stat() {
    	return D::$db->fetchline("SELECT * FROM #PX#_forum_topics_stat WHERE tid = '{$this->tid}' LIMIT 1");
    }


    //удаление топика и обновление информации о последнем сообщении в разделе
    function __delete() {
    	//удаляем информацию о теме
    	D::$db->exec("DELETE FROM #PX#_forum_topics WHERE tid = '{$this->tid}' LIMIT 1");
    	D::$db->exec("DELETE FROM #PX#_forum_topics_stat WHERE tid = '{$this->tid}' LIMIT 1");
    	$this->section->runStatRebuild();
		return $this->tid;
    }

	public function object_id() {
        return "forum-forumtopic-".$this->tid;
    }

    /**
     * Создание нового топика
     */
	function create() {
		//$this->tid = D::$db->exec("INSERT INTO #PX#_forum_topics (sid,title,descr, uid, username, add_time)
		 //                          VALUES ('{$this->sid}','{$this->title}','{$this->descr}','{$this->uid}','{$this->username}', UNIX_TIMESTAMP())");
		D::$db->exec("INSERT INTO #PX#_forum_topics_stat (tid, readed, messages, lastupdate, lastuid, lastusername) VALUES
		('{$this->tid}',0,1,UNIX_TIMESTAMP(), '{$this->uid}', '{$this->username}') ON DUPLICATE KEY
		UPDATE lastupdate = UNIX_TIMESTAMP(), lastuid = VALUES(lastuid), lastusername = VALUES(lastusername)");
		//топик до
		$section = $this->section->setUpdatedStat(array('tid'=>$this->tid, 'uid'=> $this->uid, 'update' => time(),
    		                                            'username'=> $this->username, 'topics'=> 1,
    		                                            'messages'=>1, 'title'=> $this->title, 'comid' => 0));
    }

    static function __table() {
    	return '#PX#_forum_topics';
    }
    static function __fields() {
    	return ['title','descr','upd_time','uid','username','add_time'];
    }
    static function __pk() {
    	return ['tid'];
    }

    function __save() {
    	if($this->tid == 0 ){
    		$this->__save_record();
    		$this->create();
    	} else {
    		return $this->__save_record();
    	    //D::$db->exec("UPDATE #PX#_forum_topics SET title = '{$this->title}', descr = '{$this->descr}', upd_time =  UNIX_TIMESTAMP() WHERE tid = '{$this->tid}' LIMIT 1");
    	}
    	return $this->tid;
    }

    function updateReaded() {
    	D::$db->exec("UPDATE #PX#_forum_topics_stat SET readed = readed + 1 WHERE tid = '{$this->tid}' LIMIT 1");
    }



    /**
     * Обновляем количество прочитанных сообщения для данного топика
     */
    static function comInc($tid,$comment) {
    	$topic = D_Core_Factory::Forum_Topic($tid);
    	if($topic) {
    		$topic->section->setUpdatedStat(array( 'tid' => $tid, 'uid' => $comment->uid, 'update' => time(),
    			                       'username' => $comment->username, 'topics' => 0, 'messages' => 1,
    			                          'comid' => $comment->comid, 'title' => $topic->title));

    		D::$db->exec("UPDATE #PX#_forum_topics_stat SET messages = messages + 1,
    		                                              lastupdate = UNIX_TIMESTAMP(),
    		                                                 lastuid = '{$comment->uid}',
    		                                            lastusername = '{$comment->username}',
    		                                               lastcomid = '{$comment->comid}' WHERE tid = '{$tid}' LIMIT 1");
    	} else {
    		trigger_error("Updating comments status for non-existed theme TID: {$tid}");
    	}
    }

    static function comDec($tid,$meta) {
    	D::$db->exec("UPDATE #PX#_forum_topics_stat SET messages = messages - 1 WHERE tid = '{$tid}' LIMIT 1");
    	return true;
    }

}
?>