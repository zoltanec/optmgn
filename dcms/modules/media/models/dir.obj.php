<?php
//каталог
class Media_Dir extends D_Core_Object {
    use D_Helpers_Parents;
	use D_Db_ActiveRecord;
    
    const CREATE = 1;
	//список внутренних вызовов к
	static protected $cacheable = array('files'=>100, 'subdirs'=>100, 'subdirs_all'=>2,'files_all'=> 5,'path_tree'=>20);
	//время кэширования готового объекта
	static public $cacheself = 30;
	//доступные разрешения для дополнительной загрузки
	static public $additional_dimensions = array('1280x1024', '1680x1050', '1920x1080');
	// список полей
	public $dirid;
	public $parentid = '';
	// приоритет
	public $priority = 0;
	//отдельный шаблон для отображения
	public $template = '';

    protected function __object_id() {
		return array($this->dirid);
	}

	static protected function __table() {
		return '#PX#_media_dirs';
	}
	static protected function __pk() {
		return ['dirid'];
	}
	static protected function __fields() {
		return ['parentid', 'add_time', 'active', 'priority'];
	}
    
	/**
	 * Get media dir object by it ID
	 *
	 * @param string $dirid - unique directory id
	 * @return Media_Dir $dir - instance of Media_Dir class
	 *
	 */
	static public function __fetch($dirid) {
        if($dirid == 'root') {
			$dir = new self();
			$dir->dirid = 'root';
			$dir->dirname = 'Root';
			return $dir;
		}
        $obj = D::$db->fetchobject("SELECT b.*, a.* FROM #PX#_media_dirs a LEFT OUTER JOIN #PX#_media_dirs_stat b USING (dirid) WHERE a.dirid = '{$dirid}' LIMIT 1",__CLASS__);
        if(empty($obj) && ( self::CREATE )) {
            $dir = self::CreateDir($dirid);
			return $dir;
		}
		return $obj;
	}
    
	/**
	 * Возвращаем родительский объект
	 */
	public function __get_parent() {
		return D_Core_Factory::Media_Dir($this->parentid);
	}

	//Переименовать в activeChildren
	//Получить активные дирректории
	function __get_subdirs() {
		return D::$db->fetchobjects("SELECT b.*, a.* FROM #PX#_media_dirs a
			LEFT OUTER JOIN #PX#_media_dirs_stat b
			USING (dirid)
			WHERE a.parentid = '{$this->dirid}' and a.active
			ORDER BY a.priority, a.dirname ASC, a.add_time DESC",__CLASS__);
	}

	//Переименовать Children
	//Получить все дирректории
	function __get_subdirs_all() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_media_dirs WHERE parentid = '{$this->dirid}'",__CLASS__);
	}


	function rebuildDirStat(&$history = array()) {
		$mystat = array('pictures_count' => 0, 'videos_count' => 0, 'audios_count' => 0, 'subdirs_count' => 0);
		if(array_search($this->dirid, $history) === false ) {
			// сохраняем код каталога в истории
			$history[] = $this->dirid;
			$subdirs = $this->subdirs();
			// рекурсивно обходим все каталоги
			if(!empty($subdirs) && sizeof($subdirs) > 0 ) {
				foreach(subdirs AS $dir) {
					$stat = $dir->rebuildDirStat($history);
					$mystat['subdirs_count']++;
					// объединяем статистику
					foreach(array_keys($stat) AS $key) {
						$mystat[$key] += $stat[$key];
					}
				}
			} else {
				$mystat['subdirs_count'] = 0;
			}
			$files = $this->__get_files();
			if(!empty($files) && sizeof($files) > 0 ) {
				$types = array('picture' => 'pictures_count', 'video' => 'videos_count', 'audio' => 'audios_count');
				foreach($files AS $file) {
					if(isset($types[$file->type])) {
						$field = $types[$file->type];
						$mystat[$field]++;
					}
				}
			} else {
				$mystat['pictures_count'] = $mystat['videos_count'] = $mystat['audios_count'] = 0;
			}
			// теперь обходим все файлы
			// сохраняем собственную статистику
			D::$db->exec("INSERT INTO #PX#_media_dirs_stat (dirid, pictures_count, videos_count, audios_count, subdirs_count)
  			              VALUES ('{$this->dirid}', '{$mystat['pictures_count']}', '{$mystat['videos_count']}', '{$mystat['audios_count']}','{$mystat['subdirs_count']}' )
            	          ON DUPLICATE KEY UPDATE
            	          pictures_count = '{$mystat['pictures_count']}', videos_count = '{$mystat['videos_count']}',
            	          audios_count = '{$mystat['audios_count']}', subdirs_count = '{$mystat['subdirs_count']}'");
			$this->flush();
			return $mystat;
			// похоже мы уже обрабатывали этот каталог, бага
		} else {
			return $mystat;
		}
	}

	/**
	 * Функция ищет предыдущий и следующий файл для определенного идентификатора
	 * @param string $fileid - идентификатор файла по которому ищем
	 */
	public function FindPrevNextFiles($fileid) {
		foreach($this->files AS $i => $file) {
			if($file->fileid == $fileid) {
				if(isset($this->files[$i+1])) {
					$next = $this->files[$i+1]->fileid;
				}
				if(isset($this->files[$i-1])) {
					$prev = $this->files[$i-1]->fileid;
				}
			}
		}
		//если фотка крайняя то делаем замыкание по альбому
		if(!isset($next)) {
			$next = $this->files[1]->fileid;
		}
		if(!isset($prev)) {
			$prev = $this->files[sizeof($this->files)-1]->fileid;
		}
		//возвращаем результат
		return array('prev'=> $prev, 'next'=>$next);
	}

	//!Получение списка родителей поднимаясь вверх по дереву к корню root для формирования ЧПУ и Хлебных крошек
	/**
	  * $container - возвращать не массив объектов, а массив свойств в качестве аобъектов
	  * $top_parent - id родителя верхнего уровня до которого ищем
	  */
	function getParentsList($container=false, $top_parent='root', $entry_point=true) {
		$parents_list = array();
		$parent = $this->parent;
		if($container)
			$parents_list[] = $parent->{$container};
		else $parents_list[] = $parent;
		if($this->parentid != $top_parent){
			$parents_list = array_merge($parents_list,$parent->getParentsList($container, $top_parent, false));
		}
		if($entry_point==true){
			$parents_list = array_reverse($parents_list);
		}
		return $parents_list;
	}

	function setBreadCrumbs() {
		foreach($this->getParentsList() as $parent) {
			D::$tpl->addBC('~/ls/dir_' . $parent->dirid, $parent->dirname);
		}
	}

	function __flush() {
		return $this->dirid;
	}

	//Cохранение каталога
	protected function __save() {
		if($this->dirid == 'root') {
			$this->parentid = '';
		}
		//Если при создании не указали идентификатор каталога
		//формируем автоматом
		if(!$this->dirid) {
			$this->dirid=preg_replace("/[^A-Za-z0-9_]+/", "_", D_Core_i18n::translit($this->dirname));
		}
		//Если переименовали dirid то изменяем поле в объектах
		D::$db->exec("INSERT INTO #PX#_media_dirs (dirid,dirname,parentid,descr,watermark_enable,add_time)
        VALUES ('{$this->dirid}','{$this->dirname}','{$this->parentid}','{$this->descr}','{$this->watermark_enable}', UNIX_TIMESTAMP())
        ON DUPLICATE KEY UPDATE
         	   dirid = '{$this->dirid}',
        	 dirname = '{$this->dirname}',
        	  active = '{$this->active}',
        	parentid = '{$this->parentid}',
        	   descr = '{$this->descr}',
        	  naming = '{$this->naming}',
         file_naming = '{$this->file_naming}',
    watermark_enable = '{$this->watermark_enable}',
    		priority = '{$this->priority}',
		add_time = UNIX_TIMESTAMP()");
		return $this->dirid;
	}

	/**
	 * Удаление каталога и картинок
	 */
	protected function __delete() {
		//Добавить удаление всех соответствующих картинок и др.объектов из файловой систем
    //var_dump(count($this->files_all));exit;
		D::$db->exec("DELETE FROM #PX#_media_dirs WHERE dirid = '{$this->dirid}' LIMIT 1");
    if(count($this->files_all)) {
      foreach($this->files_all as $file) {
        $file->delete();
      }
    }
    //Удаляем дирректорию каталога
    D_Core_Filesystem::deleteDir(D::$content_path . "/media/" . $this->dirid);
    D_Core_Filesystem::deleteDir(D::$content_path . "/media/thumbs/" . $this->dirid);
    return $this->dirid;
	}

	//Получить файлы определенного типа $type
	protected function getDirListing($type) {
		return array_filter($this->files, function($mediafile) use($type) { return ($mediafile->type == $type) ? true : false; });
	}

	//Получить файлы отсортированные по типам
	protected function __get_media_types() {
		return array('video' => array('name'=> 'Видео', 'content' => $this->videofiles),
    	             'audio' => array('name'=>'Аудио', 'content' => $this->audiofile),
    	             'pictures' => array('name'=> 'Изображения', 'content'=>$this->picfiles));
	}

	//Находим файлы связанные с данным каталогом
	function __get_picfiles() {
		return $this->getDirListing('picture');
	}

	function __get_audiofiles() {
		return $this->getDirListing('audio');
	}

	function __get_videofiles() {
		return $this->getDirListing('video');
	}

	//Переименовать sortFilesByType
	//Все файлы отсортированные по типам
	function __get_files() {
		return D::$db->fetchobjects("SELECT * FROM (SELECT * FROM #PX#_media_files
			WHERE parentid = '{$this->dirid}'
			ORDER BY type DESC,
			add_time ASC) files_by_add_time
			ORDER BY priority DESC
			",'Media_File');
	}

	//Все файлы отсортированные по приоритету
	function __get_files_all() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_media_files
			WHERE parentid = '{$this->dirid}'
			ORDER BY priority,
			add_time DESC",'Media_File');
	}

	function __get_files_count() {
		if(isset($this->pictures_count) && isset($this->videos_count) && isset($this->audios_count)) {
			return $this->pictures_count + $this->videos_count + $this->audios_count;
		} else {
			return 0;
		}
	}

	function __get_updated_files() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_media_files a WHERE a.parentid = '{$this->dirid}' AND (UNIX_TIMESTAMP()-add_time)/(3600*24)<7 ORDER BY  a.type DESC, a.priority DESC, a.fileid DESC",'Media_File');
	}

	//функция получает все папки имеющшиеся в папке "upload", т.е. папки для импорта
	//Применить файловый манагер или  D_Core_Filesystem
	static function uploadsubdir() {
		$path = D::$content_path . "/media/upload/";
		//var_dump($path);
		if(is_dir($path)){
			$dh = opendir($path);
			while (($dir = readdir($dh)) !== false ) {
				if (is_dir($path . $dir) && $dir !== '.' && $dir !== '..') {
					$subdir[] =  $dir;
				} else {
					continue;
				}
			}
			closedir($dh);
		}
		return $subdir;
	}

	//рекурсивный обход папок для импорта...
	static function ScanDir($dir) {
		$i = 0;
		$files = array();
		$ite=new RecursiveDirectoryIterator($dir); //стандартный класс, появившийся в PHP 5
		foreach (new RecursiveIteratorIterator($ite) as $filename) {
			if (!is_dir($filename)) {
				$files[$i] = $filename;
				$i++;
			}
		}
		return $files;
	}

	//проверяем существование каталога
	static function exists($dirid) {
		$response = D::$db->fetchline("SELECT COUNT(1) AS count FROM #PX#_media_dirs WHERE dirid = '{$dirid}'");
		if($response['count']!=0) {
			return true;
		} else return false;
	}

	//Для формирования древовидного селекта без лишних шаблонов @TODO баг если создали дир с пустым именем
	static function getDirsTree($parentid = 'site', $offset = 0) {
		$nodes = array();
		if($parentid != 'site')
			$offset++;
		$dirs = self::getDirs($parentid);
		//subdirs_all
		foreach ( $dirs as $num => $dir ) {
			$children = self::getDirsTree($dir->dirid, $offset);
			$dir->offset = $offset;
			$nodes[] = $dir;
			//if(sizeof($children) > 0) {
			//	$nodes = array_merge($nodes, $children);
			//}
		}
		return $nodes;
	}

	//Список всех каталогов в системе
	static function getDirs($parentid = 'root', $filter = array(), $order = 'add_time, priority desc', $limit = false) {
		$filter[] = "parentid = '{$parentid}'";
    if($limit)
      $limit = "LIMIT " . $limit;
		if($order)
			$order="ORDER BY {$order}";
		return D::$db->fetchobjects("SELECT * FROM #PX#_media_dirs"
                                . D_Db_Query::getWhere($filter)
                                . " {$order} {$limit}",__CLASS__);
	}

	//Для создания дирректории в админке подключаемого модуля
	static function includeDir($dirid) {
		if(Media_Dir::exists($dirid)) {
			return D_Core_Factory::Media_Dir($dirid);
		} else {
			if(D::getContext() == 'admin')
				$module = D::$req->textID('param1');
			else $module = D::$req->module;
			if(!$module) {
				throw new D_Core_Exception("MODULE_NOT_EXISTS", EX_OTHER_ERROR);
			}
			$dir = new self();
			//идентификатор каталога
			$dir->dirid = $dirid;
			$dir->dirname = $dirid;
			//Берем имя модуля в качестве ID родителя
			$dir->parentid = $module;

			//mkdir(D::$content_path."/images/".$module."/".$dir->dirid);
			//mkdir(D::$content_path."/images/".$module."/thumbs/".$dir->dirid);
			$dir->save();
			return $dir;
		}

		//Если медиатека подключается для другого модуля, то сохраняем в images/module/object_id

		//Удалить все файлы в dObject
		//if(is_dir(/images/module/object_id)) //object_id=page[module]_name
		//unlink(D::$content_path."/images/$module/{$this->textid}");

	}

	static function createDir($dirname){
		$dir = new self();
		//идентификатор каталога
		$dir->dirid = $dirname;
		$dir->dirname = $dirname;
		mkdir(D::$content_path."/media/".$dir->dirid);
		mkdir(D::$content_path."/media/thumbs/".$dir->dirid);
		$dir->save();
        return $dir;
	}
}
?>