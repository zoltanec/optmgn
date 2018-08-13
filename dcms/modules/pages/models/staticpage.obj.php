<?php
//!Объект для работы со статическим контентом
class Pages_StaticPage extends D_Core_Object {
	//!Время кэширования
	static public $cacheself = 1;
	//!Идентификатор контента
	public $content_id = 0;
	//!Тип контента
	public $content_type;
	//!Идентификатор родительского контента
	public $parent_id = 0;
	//!Заголовок окна
	public $title = '';
	//!Заголовок страницы
	public $pagetitle = '';
	//!Описание
	public $description = '';
	//!Cодержимое страницы
	public $content = '';
	public $add_time;
	public $upd_time;
	public $keywords;
	public $metatags;
	//!Флаг активности
	public $active = 0;
	//!Язык страницы
	public $lang = '';
	//!разрешены ли комментарии к объекту
	public $comments = false;

	//!режим статистики
	/*
	 * 1 - не ведем статистику;
	 * 2 - ведем количество просмотров и время последнего доступа;
	 * 3 - ведем запись всех обращений к странице, с сохранением IP пользователя и времени доступа, но без агрегированной статистики;
	 * 4 - режим 3 + режим 2;
	 */

	//!Cписок родителей
	public static $total;
	public static $stat_modes = array(1,2,3,4);
	public static $content_types = array('Документ'=>'document','Документ список'=>'document-list','Аккордеон'=>'accordion-list', 'Аккордеон контент'=>'accordion-content', 'Список с контентом'=>'list-n-content', 'Табы'=>'tabs', 'Модуль'=>'module','Ссылка'=>'link');


	//!вызовы статических функций доступные для кэширования
	public static function __fetch($content_search, $lang = 'en', $search_type = 'id') {
		if($search_type == 'id') {
			$page = D::$db->fetchobject("SELECT * FROM #PX#_static_pages WHERE content_id = '{$content_search}' LIMIT 1",__CLASS__);
		} else {
			$page = D::$db->fetchobject("SELECT * FROM #PX#_static_pages WHERE alias = '{$content_search}' and lang = '{$lang}' LIMIT 1",__CLASS__);
		}
		if($page->content_type == 'link')
			$page->link = $page->content;
		if($page->content_type == 'module')
			list($page->module, $page->action) = explode('/', $page->content);
		return $page;
	}

	protected function __object_id() {
		return array($this->content_id);
	}

	public function __precache() {
		$this->touch('content_html');
	}
	protected function __get_title_part() {
		return mb_substr($this->pagetitle, 0, 40);
	}

	protected function __get_content_html() {
        preg_match_all('/\[\[include\:([a-zA-Z0-9\-\.\_]+)\]\]/', $this->content, $matches);
        $results = array();
        foreach (array_unique($matches[1]) AS $match) {
            $page = D_Core_Factory::Pages_StaticPage($match, 'name');
            $key = '[[include:' . $match . ']]';
            if ($page) {
                $results[$key] = ($page->active) ? $page->content_html : '';
            } else {
                $results[$key] = '<b>Document ' . $match . ' not found.</b>';
            }
        }
		$variables=array('#{www}' => D::$web,
						 '#{content}' => D::$content_url,
						 '#{content.images}' => D::$content_url . "/images",
						 '#{page.images}' => D::$content_url . "/images/" . $this->alias,
						 '#{theme.images}' => D::$config->themes_url.'/'.D::theme().'/images',
						 '#{theme.css}' => D::$config->themes_url.'/'.D::theme().'/css');
        return str_replace(array_keys($results), array_values($results), str_replace(array_keys($variables), array_values($variables), $this->content));
    }

    function existsPageDir($imagesDir) {
        return (is_dir($imagesDir)) ? true : false;
    }
    
    function createDir() {
        $imagesDir = D::$content_path . "/images/pages/{$this->alias}";
        if(!$this->existsPageDir($imagesDir)) {
            mkdir($imagesDir, 0777);
        }
    }

	//!Сохранение данных страницы
	protected function __save() {
		if($this->content_id == 0) {
			$this->content_id = D::$db->exec("INSERT INTO #PX#_static_pages (add_time,upd_time) VALUES (UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
		}
        if($this->content_type != 'link' && $this->content_type != 'module') {
            $this->createDir();
        }
		//Инициализация пустых полей
		if( !$this->menutitle )
			$this->menutitle = $this->pagetitle;

		if( !$this->title || $this->title=='New page' )
			$this->title = $this->pagetitle;

		D::$db->exec("UPDATE #PX#_static_pages SET parent_id='{$this->parent_id}',
												title='{$this->title}',
												pagetitle='{$this->pagetitle}',
												menutitle='{$this->menutitle}',
												keywords='{$this->keywords}',
												description = '{$this->description}',
												metatags = '{$this->metatags}',
												link_attributes = '{$this->link_attributes}',
												content_type = '{$this->content_type}',
												alias = '{$this->alias}',
												content = '{$this->content}',
												redirect = '{$this->redirect}',
												template = '{$this->template}',
												priority = '{$this->priority}',
												active = '{$this->active}',
												menu = '{$this->menu}',
												comments = '{$this->comments}',
												stat_mode = '{$this->stat_mode}',
												lang = '{$this->lang}' WHERE content_id= '{$this->content_id}' LIMIT 1");
		return $this->content_id;
	}

	//!Выполняем запись статистики
	function updateStat() {
		if($this->stat_mode == 2 OR $this->stat_mode == 4 ) {
			D::$db->exec("INSERT INTO #PX#_static_pages_reads (content_id, last_time, readed) VALUES ('{$this->content_id}', UNIX_TIMESTAMP(), 1)
			ON DUPLICATE KEY UPDATE readed = readed + 1, last_time = UNIX_TIMESTAMP()");
		}
		if($this->stat_mode == 3 OR $this->stat_mode == 4 ) {
			D::$db->exec("INSERT INTO #PX#_static_pages_reads_detailed (ip,content_id,read_time)
						  VALUES ( INET_ATON('".D::$req->getIP()."'), '{$this->content_id}', UNIX_TIMESTAMP())");
		}
	}

	//!Удаление страницы из базы данных
	protected function __delete() {
		$children = $this->getChildrenByPid($this->content_id);
		foreach ( $children as $page) {
			$page->delete();
		}
		D::$db->exec("DELETE FROM #PX#_static_pages WHERE content_id = '{$this->content_id}' LIMIT 1");
		return $this->content_id;
	}

	function __get_children(){
		return self::getChildrenByPid($this->content_id);
	}

	function __get_activeChildren(){
		return self::getActiveChildrenByPid($this->content_id);
	}

	function __get_menuChildren() {
		return self::getMenuChildrenByPid($this->content_id);
	}

	//!Получение родительского объекта
	function __get_parent() {
		if($this->parent_id == 0) {
			$parent = new Pages_StaticPage();
			$parent->alias = 'site';
			return $parent;
		}
		return D_Core_Factory::Pages_StaticPage($this->parent_id);
	}

	//!Получить аннотацию из куска контента, если нет поля аннотация
	function __get_annotation() {
		$annotation_left = D::$config->setting->annotation_left;
		if(!$this->annotation){
			$annotation = preg_replace('/<table.*?>.*?<\/table>/si','',$this->content);
			$annotation = preg_replace(array('/\[\w+\]/','/\[\/\w+\]/'),array('',''),strip_tags(addslashes($annotation)));
			$annotation = trim($annotation);
			//Настройка обрезки
			$annotation_cut = D::$config->setting->annotation_cut;
			//Настройка по умолчанию
			if(!$annotation_cut)
				$annotation_cut = 150;
			if(mb_strlen($annotation) > $annotation_cut) {
				//Отслеживаем позицию последней точки входящей в обрезку
				$point_pos = mb_strrpos(mb_substr($annotation, 0, $annotation_cut), '.');
				$cut_pos = $point_pos;
				$annotation = mb_substr($annotation, 0, $cut_pos);
			}
			$annotation .= $annotation_left;
		} else {
			$annotation = $this->annotation . $annotation_left;
		}
		return $annotation;
	}

	//!Получение дочерних объектов по идентифкатору
	static function getChildrenByPid($pid) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_static_pages WHERE parent_id = '{$pid}' ORDER BY priority DESC",__CLASS__);
	}

	//!Получение активных дочерних объектов по идентифкатору
	static function getActiveChildrenByPid($pid) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_static_pages WHERE parent_id = '{$pid}' and active=1 ORDER BY priority DESC",__CLASS__);
	}

	//!Получение активных в меню дочерних объектов по идентифкатору
	static function getMenuChildrenByPid($pid) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_static_pages WHERE parent_id = '{$pid}' and menu=1 ORDER BY priority DESC",__CLASS__);
	}

	//Превью иконки страницы
	function __get_thumb_icon() {
		$icon_path = D::$content_url . "/images/pages/thumbs/diricon/{$this->alias}.jpg";
		return self::getImage($icon_path);
	}
	//Иконка страницы
	function __get_icon() {
		//{$this->parent->alias}
		$icon_path = D::$content_url . "/images/pages/diricon/{$this->alias}.jpg";
		return self::getImage($icon_path);
	}
	//Иконка пункта в меню
	function __get_menuicon() {
		$icon_path = D::$content_url . "/images/{$this->alias}/{$this->alias}_menu.jpg";
		return self::getImage($icon_path);
	}

	static function getImage($img_path) {
		$headers = get_headers($img_path);
		if(strpos($headers[0], '200'))
			return "<img src='$img_path' />";
	}

	//!Получение списка родителей поднимаясь вверх по дереву к корню root
	/**
	  * $container - возвращать не массив объектов, а массив свойств в качестве аобъектов
	  * $top_parent - id родителя верхнего уровня до которого ищем
	  */

	function getParentsList($container=false, $top_parent=0, $entry_point=true) {
		$parents_list = array();
		if($this->parent_id != $top_parent){
			$parent = $this->parent;
			if($container)
				$parents_list[] = $parent->{$container};
			else $parents_list[] = $parent;
			$parents_list = array_merge($parents_list,$parent->getParentsList($container, $top_parent, false));
		}
		if($entry_point==true){
			if($container=='content_id')
				$parents_list[] = 0;
			$parents_list = array_reverse($parents_list);
		}
		return $parents_list;
	}

	function setBreadCrumbs() {
		foreach($this->getParentsList() as $parent) {
			D::$tpl->addBC($parent->HURL, $parent->title);
		}
	}

	function checkActive() {
		//if($this->node_active)
		//	return true;
		if( D::$req->current_url == $this->HURL )
			return true;
	}

	function __get_HURL() {
		if($this->content_type == 'link' && $this->alias) {
			if($this->redirect)
				return D::$web . '/core/redirect/' . base64_encode($this->content);
			return $this->content;
		}
		//if($this->content_type == 'module')
		//	return D::$web . '/' . $this->content;

		$parents = $this->getParentsList('alias');
		if(count($parents))
			$hurl = implode('/',$parents).'/'.$this->alias;
		else
			$hurl =  $this->alias;
		return D::$web . '/' . $hurl;
	}

	static function rewriteURL($parent_id=0) {
		$tree = self::getChildrenByPid($parent_id);

		foreach($tree as $page){
			if($page->content_type) {
				$page->HURL = str_replace(D::$web . '/', '', $page->HURL);
				if($page->content_type == 'module')
					D_Core_Runner::$cfg['url_rewrites'][$page->HURL] = $page->content;
				else D_Core_Runner::$cfg['url_rewrites'][$page->HURL] = 'pages/' . $page->alias;
			}

			if(count($page->children))
				self::rewriteURL($page->content_id);
		}
		//var_dump(D_Core_Runner::$cfg['url_rewrites']);exit;
		return true;
	}

	//Для формирования древовидного селекта без лишних шаблонов
	static function getTree($parent_id=0, $offset=0, $active=false) {
		$nodes=array();
		$total = 0;
		if($parent_id)
			$offset++;
		if($active)
			$pages = self::getActiveChildrenByPid($parent_id);
		else
			$pages = self::getChildrenByPid($parent_id);
		$total = sizeof($pages);
		foreach ( $pages as $num => $page ) {
			$children = self::getTree($page->content_id, $offset,  $active);
			$page->offset = $offset;
			$nodes[] = $page;
			if(($total_children = sizeof($children))>0) {
				$total = $total + $total_children;
				$nodes=array_merge($nodes,$children);
			}
		}
		self::$total=$total;
		return $nodes;
	}


	/**
	* Сформировать массив для вывода дерева объектов
	*
	*  $parent_id = идентификатор страницы с которой начинать дерево
	*  $active = возвращать только активные страницы
	*  $sort = сортировать на каталоги и файлы. (каталоги первые файлы идут после них)
	*/

	static function getTreeArray($parent_id=0,$sort=false,$current_id=0) {
		$nodes = array();
		$nochildren = array();
		//В зависимости от контекста
		if ( D::getContext() == 'user' ) {
			$pages = self::getMenuChildrenByPid($parent_id);
		} else {
			$pages = self::getChildrenByPid($parent_id);
		}
		//Формируем дерево
		foreach ( $pages as $num => $page ) {
			$page->childrenTree = self::getTreeArray($page->content_id,$sort,$current_id);
			if ( count($page->childrenTree) == 0 && $sort ) {
				$nochildren[] = $page;
			} else {
				$nodes[$page->alias] = $page;
			}
		}
		//Сортируем
		if ($sort) {
			foreach ( $nochildren as $num => $page ) {
				$nodes[$page->alias] = $page;
			}
		}
		return $nodes;
	}

	/**
	* Возвращает массив объектов страниц
	* с идентификаторами страниц взятыми из массива.
	*/

	static function getPagesByIdArray($id_array) {
		$id_list = implode(',', $id_array);
		return D::$db->fetchobjects("SELECT * FROM #PX#_static_pages WHERE content_id IN (".$id_list.") ORDER BY FIELD(`content_id`, ".$id_list.")",__CLASS__);
	}
 }
?>