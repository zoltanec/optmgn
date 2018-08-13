<?php
//объект для работы со статическим контентом
class Pages_StaticPage extends D_Core_Object {
    //время кэширования
	static public $cacheself = 1;
    //идентификатор контента
    public $content_id = 0;
	public $content_type = '';

	public $furl = '';
    public $title = '';
	public $long_title = '';
	public $description = '';
	public $content = '';
	public $adddon = 0;
	public $addby = 0;
	public $editdon = 0;
	public $editby = 0;
	public $keywords = 0;
	public $metatags = 0;
	public $active = 0;
	public $lang = '';
	//разрешены ли комментарии к объекту
	public $comments = false;
	//режим статистики
	// 1 - не ведем статистику;
	// 2 - ведем количество просмотров и время последнего доступа;
	// 3 - ведем запись всех обращений к странице, с сохранением IP пользователя и времени доступа, но без агрегированной статистики;
	// 4 - режим 3 + режим 2;
	public static $stat_modes = array(1,2,3,4);

    //вызовы статических функций доступные для кэширования
    static function __fetch($content_search, $lang = 'en', $search_type = 'id') {
    	if($search_type == 'id') {
			return D::$db->fetchobject("SELECT * FROM #PX#_static_pages WHERE content_id = '{$content_search}' LIMIT 1",__CLASS__);
    	} else {
    		return D::$db->fetchobject("SELECT * FROM #PX#_static_pages WHERE content_name = '{$content_search}' and lang = '{$lang}' LIMIT 1",__CLASS__);
    	}
	}

	public function __precache() {
		$this->touch('content_html');
	}

	function __object_id() {
		return array($this->content_id);
    }

    protected function __get_title_part() {
    	return mb_substr($this->title, 0, 40);
    }

	protected function __get_content_html() {
		//preg_match_all('/\[\[include:([a-zA-Z0-9\-\.\_]+)\]\]/', $this->content, $matches);
		preg_match_all('/\[\[include\:([a-zA-Z0-9\-\.\_]+)\]\]/', $this->content, $matches);
		$results = array();
		foreach(array_unique($matches[1]) AS $match) {
			$page = dFactory::StaticPage($match, 'name');
			$key = '[[include:'.$match.']]';
			if($page) {
				$results[$key] = ($page->active) ? $page->content_html : '';
			} else {
				$results[$key] = '<b>Document '.$match.' not found.</b>';
			}
		}
		$variables = array('[[www]]' => D::$Tpl->me['www'], '[[content]]' => D::$Tpl->me['content'],
		          '[[theme.images]]' => D::$config->themes_path.'/'.D::theme().'/images',
		             '[[theme.css]]' => D::$config->themes_path.'/'.D::theme().'/css');
		return str_replace(array_keys($results), array_values($results), str_replace(array_keys($variables), array_values($variables), $this->content));
	}
	/**
	 * Сохранение данных страницы
	 */
	protected function __save() {
		if($this->content_id == 0) {
			$this->content_id = D::$db->exec("INSERT INTO #PX#_static_pages (title,add_time,upd_time)
			                                 VALUES ( '{$this->title}',UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
		} else {
		   D::$db->exec("UPDATE #PX#_static_pages SET title = '{$this->title}',  description = '{$this->description}', content_name = '{$this->content_name}',
		                	                        content = '{$this->content}',     active = '{$this->active}',          comments = '{$this->comments}',
		                	                      stat_mode = '{$this->stat_mode}',      lang = '{$this->lang}'
		                	                       WHERE content_id= '{$this->content_id}' LIMIT 1");
		}
		return $this->content_id;
	}

	/**
	 * Выполняем запись статистики
	 */
	function updateStat() {
		if($this->stat_mode == 4 OR $this->stat_mode == 2 ) {
			D::$db->exec("INSERT INTO #PX#_static_pages_reads (content_id, last_time, readed) VALUES ('{$this->content_id}', UNIX_TIMESTAMP(), 1)
			ON DUPLICATE KEY UPDATE readed = readed + 1, last_time = UNIX_TIMESTAMP()");
		}
		if($this->stat_mode == 3 OR $this->stat_mode == 4 ) {
			D::$db->exec("INSERT INTO #PX#_static_pages_reads_detailed (ip,content_id,read_time)
			              VALUES ( INET_ATON('".D::$req->getIP()."'), '{$this->content_id}', UNIX_TIMESTAMP())");
		}
	}

	/**
	 * Улаоение страницы из базы данных
	 */
	protected function __delete() {
		D::$db->exec("DELETE FROM #PX#_static_pages WHERE content_id = '{$this->content_id}' LIMIT 1");
		return $this->content_id;
	}
 }
?>