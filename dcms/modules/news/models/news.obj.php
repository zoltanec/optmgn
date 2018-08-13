<?php
//описание объектов
class News_News extends D_Core_Object implements Comments_Commentable {
    use D_Files_Icon;
    use D_Db_Pager;
    
    //заголовок новости
    public $title = '';
    //Псевдоним новости
    public $alias;
    //маппинг объекта на базу данных
    //контент новости
    public $content = '';
    public $nid = 0;
    public $sid = 0;
    public $section_name = '';
    public $mode = 'html';
    public $readed = 0;
    public $priority = 0;
    // превью статьи
    public $content_preview = '';
    // задержка публикации
    public $publish_delay = false;
    public $pub_time = 0;
    public $upd_time = 0;
    static public $fetch_query = "SELECT/*COLS*/a.*, b.section_name,b.section_key, c.comments,c.readed, d.content/*/COLS*/FROM #PX#_news a
    LEFT OUTER JOIN #PX#_news_sections b USING (sid)
    LEFT OUTER JOIN #PX#_news_stat c USING (nid)
    LEFT OUTER JOIN #PX#_news_content d USING (nid)";
    //время кэширования объекта при fetch запросе
    static public $cacheself = 0;
    //вызовы статических функций доступные для кэширования
    static protected $cachestatic = array('LatestNews'=> 5, 'DayGrouped' => 60, 'getByMonth'=>60);
    static protected $cachehard   = array('LatestNews' => 1 );
    static public $icon_dirs=array("/news/icons/","/news/thumbs/");
    static public $total_pages;
	
	
    function __construct() {
        if($this->readed == NULL) $this->readed = 0;
        if($this->comments == NULL) $this->comments = 0;
    }

    public static function __fetch($nid) {
    	 return  D::$db->fetchobject(self::$fetch_query . "	WHERE a.nid = '$nid' LIMIT 1",__CLASS__);
    }
    
    static public function __module() {
        return 'news/';
    }

    /**
     * Идентификатор объекта
     *
     * @return string $id - идентификатор объекта
     */
	protected function __object_id() {
		return array($this->nid);
	}

    public function __icon_title() {
		return $this->title;
	}
  
    static function __icon_dirname() {
		return 'icons';
	}
    
    function __slider_dirname() {
		return 'slider/news' . $this->nid;
	}
  
    public function __alias() {
		return $this->alias;
	}
  
  static function __fetch_query() {
    return self::$fetch_query;
  }

  static function __pager_settings() {
    return array('url' => '/news/archive/#PAGE#', 'perpage' => 20);
  }
  
	function getTitlePart($limit = 100) {
		if(strlen($this->title) > $limit) {
			return mb_substr($this->title, 0, $limit)."...";
		} else {
			return $this->title;
		}
	}
	
	//TODO Сделать возможность выбора в конце аннотации три точки, три точки одним символом, без точек
	function __get_content_preview() {
		if(!$this->content_preview){
			$preview = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags(addslashes($this->content)));
			$preview = trim($preview);
			if(mb_strlen($preview) > 700) {
				$preview = mb_substr($preview,0,strpos($preview,'.', 700));
			}
			return $preview;
		}
		return $this->content_preview;
	}

	protected function __precache() {
		$this->touch(array('recommended_news'));
	}

	
	static function get_news_count($sid=1){
		return D::$db->fetchvar("SELECT Count(*) FROM #PX#_news WHERE sid={$sid}");
	}
	
	static function get_news_limit($offset=0,$count=10,$sid=1) {
	
		return D::$db->fetchobjects("SELECT * FROM #PX#_news  WHERE sid={$sid} ORDER BY add_time DESC LIMIT {$offset},{$count}",__CLASS__);
	}
	
	//!Ищем иконку в возможных дирректориях
	function __get_icon_path(){
		if($this->icon){
			//Дирректории в которых могут быть иконки
			foreach(self::$icon_dirs as $icon_path){
				if(file_exists(D::$config->content_path . $icon_path . $this->icon))
					return D::$config->content_url . $icon_path . $this->icon;
			}
		} else {
      return D::$config->content_url . '/images/news/thumbs/icons/' . $this->alias . '.jpg';
    }
		return false;
	}
  
  static function getImage($img_path) {
		$headers = get_headers($img_path);
		if(strpos($headers[0], '200'))
			return "<img src='$img_path' />";
	}
	/**
	 * Получаем список доступных иконок для текущего раздела
	 * Названия папок необходимо привести к стандарту:
	 * В папке любого модуля должна находится директория
	 * thumbs и директории категорий.
	 * В директории thumbs должны находится директории категорий с превью картинками.
	 */
	static function getIconsList($paths=''){
		//Картинки находящиеся в директории thumbs можно использовать в качестве иконок новостей
		if(!$paths)
			$paths = self::$icon_dirs;
		$files = array();
		//!Проверяем все доступные хранилища
		foreach($paths as $icon_dir){
			$icon_path = D::$config->content_path . $icon_dir;
			if(is_dir($icon_path)){
				$dir = opendir($icon_path);
				while(($file = readdir($dir))!==false){
					if(is_file($icon_path . "/" . $file)){
						$files[] = $file;
            //var_dump($file);
					}else{
						if($file!='.' && $file!='..')
						$files[$file] = self::getIconsList(array($icon_dir."/".$file));
					}
				}
			}
		}
		return $files;
	}

	/**
	 * Update comments count for object
	 * @see Comments_Commentable::comInc()
	 */
    public function comInc(Comments_Comment $comment, Comments_Meta $meta ) {
        D::$db->exec("INSERT INTO #PX#_news_stat (nid,comments) VALUES ('{$this->nid}',1) ON DUPLICATE KEY UPDATE comments = comments + 1");
    }
    public function comDec(Comments_Meta $meta) {
    	D::$db->exec("UPDATE #PX#_news_stat SET comments = comments - '{$meta->count}' WHERE nid = '{$this->nid}' LIMIT 1");
    }
    public function comSet(Comments_Meta $meta) {
    	return true;
    }

    protected function __delete() {
        D::$db->exec("DELETE FROM #PX#_news WHERE nid = '{$this->nid}' LIMIT 1");
        return $this->nid;
    }

    protected function __save() {
             D::$db->exec("SET time_zone = 'Asia/Yekaterinburg';");
    	if($this->nid == 0 ) {
    		 $this->nid = D::$db->exec("INSERT INTO #PX#_news (title,active,add_time,sid) VALUES ('{$this->title}',true,unix_timestamp(),'{$this->sid}')");
    	}else{
    	D::$db->exec("UPDATE #PX#_news SET title = '{$this->title}', alias = '{$this->alias}', author = '{$this->author}', active = '{$this->active}', ontop = '{$this->ontop}',
    	                                   mode = '{$this->mode}',   icon = '{$this->icon}',     tags = '{$this->tags}', comments_status = '{$this->comments_status}',
    	                                   content_preview = '{$this->content_preview}', publish_delay = '{$this->publish_delay}', add_time={$this->add_time},upd_time = UNIX_TIMESTAMP(),
    	                                   pub_time = '{$this->pub_time}', sid = '{$this->sid}', description = '{$this->description}', source = '{$this->source}' WHERE nid = '{$this->nid}' LIMIT 1");
    	}
		D::$db->exec("INSERT INTO #PX#_news_content (nid,content) VALUES ({$this->nid}, '{$this->content}') ON DUPLICATE KEY UPDATE content = '{$this->content}'");
    	return $this->nid;
    }

    protected function __get_section() {
    	return D_Core_Factory::News_Sections( (int) $this->sid);
    }

    /**
     * Загрузка списка последних новостей
     */
	static function __LatestNews($news_limit = 7,$sections_keys = array()) {
		//var_dump($sections_keys);exit;
		$sections_select = (sizeof($sections_keys) > 0 ) ? "b.section_key IN ('".implode("','",$sections_keys)."')" : 'b.public';
		//echo $sections_select;exit;
        //загружаем новости из базы
        return  D::$db->fetchobjects(self::$fetch_query .
        "WHERE a.active AND {$sections_select}  
        ORDER BY a.ontop DESC, a.nid + a.priority 
        DESC LIMIT ".intval($news_limit),__CLASS__);
    }
	
	//!Получаем массив содержащий названия месяцев дат добавления новостей и кол-во новостей в месяц
	static function __getNewsMonths($conditions=array(),$sort='desc') {
		$cond = array("a.active");
    	if(isset($conditions['current'])) {
    		$cond[] = "UNIX_TIMESTAMP()<a.add_time";
    	}
		if(isset($conditions['sid'])) {
    		$cond[] = "a.sid=".$conditions['sid'];
    	}
        $months=D::$db->fetchlines("SELECT MONTHNAME(FROM_UNIXTIME(add_time)) as monthname, COUNT(1) as cols FROM #PX#_news a
        LEFT OUTER JOIN #PX#_news_sections b USING (sid) ".D_Db_Query::getWhere($cond)." GROUP BY MONTHNAME(FROM_UNIXTIME(add_time)) ORDER BY a.add_time {$sort}",__CLASS__);
		foreach($months as $id=>$month){
			$months[$id]['rmonthname']=str_replace(array('June','July','January','August','September','October','November','December','January', 'Febrary','March','April','May'),
						array('Июнь','Июль','Январь','Август','Сентябрь','Октябрь','Ноябрь','Декабрь','Январь','Февраль','Март','Апрель','Май'),$month['monthname']);
		}
		return $months;
	}
	//!Получаем новости определенного месяца
	static function __getByMonth($month,$section) {
        return D::$db->fetchobjects("SELECT a.*, b.*, c.section_key FROM #PX#_news a
        LEFT OUTER JOIN #PX#_news_sections c USING (sid)
        LEFT OUTER JOIN #PX#_news_stat b USING (nid) WHERE a.active AND MONTHNAME(FROM_UNIXTIME(a.add_time))='{$month}' and c.section_key='{$section}' ORDER BY a.add_time ASC",__CLASS__);
    }
    static protected function __DayGrouped($limit = 40) {
        //загружаем
        $all_news = D::$db->fetchobjects("SELECT a.title, a.nid, a.sid, a.add_time,b.readed,b.comments, a.comments_status, a.content_preview,a.author, a.source,c.section_name FROM #PX#_news a
        LEFT OUTER JOIN #PX#_news_sections c USING (sid)
        LEFT OUTER JOIN #PX#_news_stat b USING (nid) WHERE a.active ORDER BY a.add_time DESC LIMIT {$limit}",__CLASS__);
        $all_data = array();
        foreach($all_news AS $id=>&$news) {
            $group = strftime('%d-%m-%G',$news->add_time);
            if(isset($all_data[$group])) {
            	//сохраняем новость
                $all_data[$group]['news'][] = $news;
            } else {
                $name = str_replace(array('June','July','January','August','September','October','November','December','January', 'Febrary','March','April','May'),
                                    array('июня','июля','января','августа','сентября','октября','ноября','декабря','января','февраля','марта','апреля','мая'),strftime('%e %B %G',$news->add_time));
                $all_data[$group] = array('name'=>$name,'news'=>array($news));
            }
        }
        return $all_data;
    }


    function countReads() {
        D::$db->exec("INSERT INTO #PX#_news_stat (nid,readed) VALUES ('{$this->nid}',1) ON DUPLICATE KEY UPDATE readed = readed + 1");
    }


    protected function __get_recommended_news() {
    	// получаем список рекомендованных новостей
    	return D::$db->fetchlines("SELECT a.nid, a.good_news, b.title FROM #PX#_news_recomendations a
    	LEFT OUTER JOIN #PX#_news b ON (a.good_news = b.nid ) WHERE a.nid = '{$this->nid}' LIMIT 5");
    }

    /**
     * Расчет рекомендованных новостей для данной новости
     */
    public function rebuildTags() {
    	// в массиве будут хранится те новости, id которых считаются хорошими
    	$good_news = array();
		// сначала разбиваем все на теги
		$tags = explode(',', $this->tags);
		$tags_list = array();
		// сначала формируем запрос
		foreach($tags AS $tag) {
			$tag = trim($tag);
			$tags_list[] = "('{$tag}', '{$this->nid}')";
		}
		D::$db->exec("DELETE FROM #PX#_news_tags WHERE nid = '{$this->nid}'");
		if(sizeof($tags_list) > 0) {
			D::$db->exec("INSERT IGNORE INTO #PX#_news_tags (tag,nid) VALUES ".implode(',', $tags_list));
		}
		return true;
    }

    /**
     * Получение списка по которому будем искать
     *
     * @param unknown_type $conditions
     */
    static function __getSearchList($conditions = array()) {
    	$cond = array();
    	if(isset($conditions['active'])) {
    		$cond[] = "a.active";
    	}
    	if(isset($conditions['title'])) {
    		$cond[] = "a.title LIKE  '%{$conditions['title']}%'";
    	}
    	if(isset($conditions['sid'])) {
    		$cond[] = "a.sid = '".$conditions['sid']."'";
    	}
    	$list = new D_Core_List();
    	$list->fetch_query = self::$fetch_query.D_Db_Query::getWhere($cond)." ORDER BY a.ontop DESC, add_time DESC";
    	$list->container(__CLASS__)->perpage(100);
    	return $list;
    }

}
?>
