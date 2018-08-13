<?php
class Comments_Meta extends D_Core_Object {
	//идентификатор объекта
	public $object_id = '';
	//хэш объекта
	public $object_hash = '';
	//URL-адрес объекта по которому его можно найти
	public $url = '';
	//можно ли размещать комментарии к данному объекту
	public $readonly = false;
	//можно ли редактировать комментарии объекта
	public $editable = true;
	//время последнего изменения комментариев или добавления новых, timestamp
	public $lastchange = 0;
	public $first = 0;
	//имя файла шаблона используемого для отображения данных комментариев
	public $template = '';

	public $count = 0;

	static public $cacheself = 0;

	static protected $cacheable = array('month_no_week_comments' => 1000,
	                                      'week_no_day_comments' => 1000,
                                                  'day_comments' => 60);

	function __construct($object_id = '', $template = '') {
		if(!empty($object_id)) {
			$this->object_id = $object_id;
			$this->object_hash = md5(strtolower($this->object_id));
			$this->template = $template;
		}
	}

	/**
	 *
	 *
	 * @param string $object_hash - хэш идентификатора объекта
	 * @param bool $allow_create - разрешить создание объекта если он не найден в базе данных
	 * @param string $object_id - идентификатор объекта
	 * @param string $template - имя файла шаблона, предопределенное;
	 */
	static public function __fetch($object_hash, $allow_create = false, $object_id = '', $template = '') {
		if(empty($object_hash) and !empty($object_id)) {
				$object_hash = md5(strtolower($object_id));
		}
		$meta = D::$db->fetchobject("SELECT a.* FROM #PX#_comments_meta a WHERE a.object_hash = '{$object_hash}' LIMIT 1",__CLASS__);

		if(!empty($meta)) {
			return $meta;
		}

		if($allow_create) {
			$meta = new self($object_id, $template);
    		$meta->save();
    		return $meta;
		} else {
    		return false;
		}
	}

	/**
	 * Get object by it ID
	 */
	public function __object_id() {
		return array($this->object_hash);
	}

	protected function __get_object() {
		return D_Core_Factory::getByID($this->object_id);
	}


	protected function __save() {
		if($this->first == 0) {
			D::$db->exec("INSERT INTO #PX#_comments_meta (object_hash, object_id, first,count,template) VALUES ('{$this->object_hash}', '{$this->object_id}', UNIX_TIMESTAMP(), '{$this->count}','{$this->template}') ON DUPLICATE KEY UPDATE last = UNIX_TIMESTAMP()");
		}
		return $this->object_hash;
	}


	/**
	 * Удаления объекта приводит к удалению всех комментариев
	 */
	protected function __delete() {
		//сначала удалим сами комментарии
		D::$db->exec("DELETE FROM #PX#_comments_all WHERE object_hash = '{$this->object_hash}'");
		//а теперь удалим саму мета информацию
		D::$db->exec("DELETE FROM #PX#_comments_all WHERE object_hash = '{$this->object_hash}' LIMIT 1");
		return $this->object_hash;
	}

	function __get_comments() {
		return $this->count;
	}


	/*количество сообщений за текущий месяц минус текущая неделя*/
	function __get_month_no_week_comments() {
		$now = dTime::Now();
		$monthStart = $now->month_start_sec;
		$weekStart = $now->week_start_sec;
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_comments_all WHERE object_hash = '{$this->object_hash}' AND add_time > {$monthStart} AND add_time < {$weekStart}");
	}

	function __get_week_no_day_comments() {
		$now = dTime::Now();
		if($now->wday == 1 ) {
			return 0;
		}
		$weekStart = $now->week_start_sec;
		$dayStart = $now->day_start;
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_comments_all WHERE object_hash = '{$this->object_hash}' AND add_time > {$weekStart} AND add_time < {$dayStart}");
	}

	function __get_month_comments() {
		return $this->month_no_week_comments + $this->week_comments;
	}

	function __get_week_comments() {
		return $this->week_no_day_comments + $this->day_comments;
	}

	function __get_day_comments() {
		$now = D_Core_Time::Now();
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_comments WHERE object_id = '{$this->object_hash}'
		AND addtime > {$now->day_start}");
	}

	function updateMeta() {
		$this->untouch(array('month_no_week_comments', 'week_no_day_comments', 'day_comments'));
		$this->flush();
	}


	/**
	 * Увеличиваем количество комментариев
	 * @param int $lastcomid - последний комментарий который был добавлен
	 */
	function incrementComments($lastcomid = 0) {
		D::$db->exec("UPDATE #PX#_comments_meta SET count = count + 1, last = NOW(), lastcomid = '{$lastcomid}' WHERE object_hash = '".$this->object_hash."' LIMIT 1");
		$this->flush();
	}


	/**
	 * Был удален комментарий
	 *  ...
	 * @param int $comid - идентификатор комментария
	 */
	function decrementComments($comid = 0 ) {
		if($comid == $this->lastcomid) {
			$lastcomid = D::$db->fetchvar('SELECT MAX(comid) FROM #PX#_comments_all WHERE object_hash = "'.$this->object_hash.'" LIMIT 1');
		}
		D::$db->exec("UPDATE #PX#_comments_meta SET count = count - 1, last = NOW() WHERE object_hash = '".$this->object_hash."' LIMIT 1");
		$this->untouch(array('month_no_week_comments','week_no_day_comments', 'day_comments'));
		$this->flush();
	}
}
?>