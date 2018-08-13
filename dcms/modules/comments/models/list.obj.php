<?php
class Comments_List extends D_Core_List {
    //объект
    protected $commented_object_id = 'all';

    static protected $cacheable = array('total'=> 10, 'meta' => 0);
	static public  $cacheself = 100;
    public static $latestCacheTime = 100;
    public $container = 'Comments_Comment';

    public $latest_count = 65;
    public static $query = "SELECT /*COLS*/ a.comid, a.title, a.content, a.upd_time, a.add_time, b.uid,
    b.username, b.karma, b.reg_time, b.avatar, b.messages, b.sign,
    a.plus, a.minus, a.object_hash, b.user_from,a.ip, a.moderator_note,
    c.group_name, c.group_color/*/COLS*/
    FROM #PX#_comments a
    LEFT OUTER JOIN #PX#_users b USING (uid)
    LEFT OUTER JOIN #PX#_users_groups c USING (gid)";

    function __construct($object_id = '') {
    	$this->commented_object_id = $object_id;
    }

    //получение общего количества комментариев для объекта
    function __get_total() {
    	return $this->meta->count;
    }

	function __get_meta() {
		try {
			$meta = D_Core_Factory::Comments_Meta(md5(strtolower($this->commented_object_id)));
			return $meta;
		} catch(Exception $e) {
			$meta = new Comments_Meta($this->commented_object_id);
		}
		return $meta;
	}


	/**
	 * Object identification
	 */
	function __object_id() {
		return array(md5($this->commented_object_id));
	}


	static function __fetch($comments_object_id = '', $page = 1, $perpage = 10, $order = 'normal') {
		$list = new self();
        $list->commented_object_id = strtolower($comments_object_id);
        //количество объектов на страницу
        $list->perpage = $perpage;
        //порядок отображения
        $list->order = $order;
        //страница для отображения
		$list->page = $page;
        //делаем выборку из базы и возвращаем результат
        $list->fetch_query = self::$query." WHERE a.object_hash = '".md5($list->commented_object_id)."' and a.approved ORDER BY comid ASC";
		return $list;
	}


	function getLatestFrom($comid, $ordermode) {
		$comments =  D::$db->fetchobjects(self::$query." WHERE a.object_hash = '".$this->meta->object_hash."' and a.comid > '{$comid}' and a.approved ORDER BY comid DESC LIMIT 20", 'Comments_Comment');
		if($ordermode == 'normal') {
			return array_reverse($comments);
		} else {
			return $comments;
		}
	}

	static function all($settings = array()) {
		$list = new D_Core_List();
        //страница для отображения
		$list->container = 'Comments_Comment';
		$cond = array();
		if(isset($settings['mode'])) {
			switch($settings['mode']) {
				case 'unapproved': $cond[] = "not a.approved";
			}
		}
		if(sizeof($cond) > 0) {
			$WHERE = "WHERE ".implode(' AND ',$cond);
		} else {
			$WHERE = '';
		}
		$list->fetch_query = "SELECT /*COLS*/ a.comid, a.title, a.content, b.sign, a.updtime, a.addtime, b.uid, b.username,b.avatar,b.messages,a.ip,a.object_id /*/COLS*/ FROM #PX#_comments a LEFT OUTER JOIN #PX#_users b USING (uid) {$WHERE} ORDER BY add_time ASC";
		return $list;
	}

	static function getNewComments($limit = 10) {
		$comments = D::$db->fetchobjects(self::$query." ORDER BY a.comid DESC LIMIT {$limit}","Comments_Comment");
		return $comments;
	}
}
?>