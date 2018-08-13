<?php
class Forum_Section extends D_Core_Object {
	/*свойства класса*/
	//идентификатор раздела
	public $sid = 0;
	//идентификатор категории
	public $cid = 0;
	//родительский раздел
	public $parent = 1;
	//имя раздела
	public $name = 'Empty';
	//описание раздела
	public $descr = '';

	static protected $cachestatic = array('Section'=> 2, 'subsections'=> 5, 'pathree'=>0, 'stat' => 60);
	static protected $cacheable = array('moderators'=> 300, 'pathtree'=> 3600, 'subsections'=> 15, 'topics' => 5, 'parent_section'=> 0, 'categories'=> 300, 'stat' => 20);
	static public $cacheself = 600;

	static public function __fetch($sid) {
    	 return  D::$db->fetchobject("SELECT * FROM #PX#_forum_sections WHERE sid = $sid LIMIT 1",__CLASS__);
    }

    /**
     * Список подразделов форума отсортированный по категориям
     * @param $sid
     */
    function __get_subsections() {
    	//разделы
    	$sections = D::$db->fetchobjects("SELECT a.*,b.*,a.sid FROM #PX#_forum_sections a LEFT OUTER JOIN #PX#_forum_sections_stat b USING (sid) WHERE a.parent = '{$this->sid}' AND a.active",__CLASS__);
    	//категории
    	$groupedByCat = array();
    	//теперь сортируем разделы по категориям
    	foreach($sections AS &$section) {
    		if(isset($this->categories[$section->cid])) {
    			if(isset($groupedByCat[$section->cid])) {
    				$groupedByCat[$section->cid]['sections'][] = &$section;
    			} else {
    				$groupedByCat[$section->cid] = array('name' => $this->categories[$section->cid]['name'], 'sections' => array(&$section));
    			}
    		} else {
    			if(isset($groupedByCat[0])) {
    				$groupedByCat[0]['sections'][] = &$section;
    			} else {
    				$groupedByCat[0] = array('name'=>'Основные', 'sections' => array(&$section));
    			}
    		}
    	}
    	return $groupedByCat;
    }

    /**
     * Список категорий в разделе
     */
    function __get_categories() {
    	return D::$db->fetchlines_clear("SELECT a.cid,a.* FROM #PX#_forum_categories a WHERE a.sid = '{$this->sid}'");
    }

    /**
     * Загружаем статистику текущего раздела из базы
     */
    protected function __get_stat() {
    	$stat = D::$db->fetchline("SELECT * FROM #PX#_forum_sections_stat WHERE sid = '{$this->sid}' LIMIT 1");
    	if(!$stat) {
    		$stat = array('lastupdate' => 0);
    	}
    	return $stat;
    }

    /**
     * Добавляем новую категорию
     */

    function addCategory($name = '') {
    	//добавляем новую категорию к разделу
    	D::$db->exec("INSERT INTO #PX#_forum_categories (name,sid) VALUES ('{$name}',{$this->sid})");
    }
    function updateCategory($cid = 1, $name = 'New Name') {
    	D::$db->exec("UPDATE #PX#_forum_categories SET name = '{$name}' WHERE cid = '{$cid}' and sid = '{$this->sid}' LIMIT 1");
    }
    function deleteCategory($cid = 1) {
    	D::$db->exec("DELETE FROM #PX#_forum_categories WHERE cid = '{$cid}' and sid = '{$this->sid}' LIMIT 1");
    }

    function __get_subsections_all() {
    	return D::$db->fetchobjects("SELECT * FROM #PX#_forum_sections WHERE parent = '{$this->sid}'",__CLASS__);
    }

    /**
     * Список всех разделов
     */
    static function AllSections() {
    	return D::$db->fetchobjects("SELECT * FROM #PX#_forum_sections",__CLASS__);
    }


    /**
     * Загрузка топиков из темы
     */
    function __get_topics() {
    	return D::$db->fetchobjects("SELECT b.*,a.* FROM #PX#_forum_topics a
		LEFT OUTER JOIN #PX#_forum_topics_stat b USING (tid)
		WHERE a.sid = '{$this->sid}' ORDER BY b.lastupdate DESC",'Forum_Topic');
    }

    function getTopicsList() {
    	$list = new D_Db_List();
    	$list->fetch_query = "SELECT /*COLS*/b.*,a.*/*/COLS*/ FROM #PX#_forum_topics a LEFT OUTER JOIN #PX#_forum_topics_stat b USING (tid) WHERE a.sid = '{$this->sid}' ORDER BY b.lastupdate DESC";
    	$list->container = 'Forum_Topic';
    	return $list;
    }



    /**
     * Возвращаем родительский раздел в виде объекта
     */
    function __get_parent_section() {
		//у корневого раздела нет родителя, так что возвращаем false
		if($this->sid == 1 ) {
			return false;
		} else {
			return D_Core_Factory::Forum_Section($this->parent);
		}
    }

    /**
     * Список модераторов раздела
     */
    function __get_moderators() {
    	return D::$db->fetchlines_clear("SELECT b.uid, b.username,  a.* FROM #PX#_forum_sections_moderators a LEFT OUTER JOIN #PX#_users b USING (uid) WHERE a.sid = '{$this->sid}'");
    }

    /**
     * Функция затычка. Удалить когда будет ACL
     */
    function isModerator($uid) {
    	return isset($this->moderators[$uid]);
    }
    /**
     * Добавить модератора
     */
    function AddModerator($uid = 0) {
    	D::$db->exec("INSERT IGNORE  INTO #PX#_forum_sections_moderators (sid,uid) VALUES ({$this->sid}, {$uid})");
    	$this->untouch('moderators',true);
    	$this->flush();
    }
    function DeleteModerator($uid = 0) {
    	D::$db->exec("DELETE FROM #PX#_forum_sections_moderators WHERE uid = '{$uid}' and sid = '{$this->sid}' LIMIT 1");
    	$this->untouch('moderators',true);
    }
    /**
     * Полный путь к данному разделу начиная от корня
     */
    function __get_pathtree() {
    	//счетчик безопасности чтобы избежать зацикливания
    	$secCount = 10;
    	$sectionsPath = array();
    	while($secCount > 0) {
    		$secCount--;
    		$parentSection = $this->parent_section;
    		$sectionsPath[] = array('name'=> $parentSection->name, 'sid' => $parentSection->sid);
    		//если мы добрались до корневого раздела то выходим из цикла
    		if($parentSection == 1) {
    			break;
    		}
    	}
    	return array_reverse($sectionsPath);
    }

	function __total_section($sid) {
		$count = D::$db->fetchline("SELECT COUNT(1) as count FROM #PREFIX#_forum_sections WHERE parent = $sid");
		return ($count['count'] > 0) ? $count['count'] : 0;
	}

	public function object_id() {
        return "forum-section-".$this->sid;
    }

    protected function create() {
    	//новый раздел мы создаем пустым и заблокированным
    	$this->sid = D::$db->exec('INSERT INTO #PX#_forum_sections (name,active,parent) VALUES ("'.$this->name.'", 0,'.$this->parent.')');
    	D::$db->exec("INSERT INTO #PX#_forum_sections_stat (sid) VALUES ({$this->sid})");
    }

    function __save() {
    	if($this->sid == 0 ){
    		$this->create();
    	} else {
    	    D::$db->exec("UPDATE #PX#_forum_sections SET name = '{$this->name}', descr = '{$this->descr}', active = '{$this->active}',
    	    readonly = '{$this->readonly}', cid = '{$this->cid}'  WHERE sid = '{$this->sid}' LIMIT 1");
    	}
    	return $this->sid;
    }

    /**
     * Обновление статистики раздела
     * Пересчитывает количество тем, количество сообщений и дату последнего сообщения
     */
    function runStatRebuild() {
    	// сначала загружаем время последнего сообщения
    	$lastupdate = D::$db->fetchline("SELECT a.sid, a.tid, a.title, b.* FROM #PX#_forum_topics a LEFT OUTER JOIN #PX#_forum_topics_stat b USING (tid) WHERE a.sid = '{$this->sid}' ORDER BY b.lastupdate DESC LIMIT 1");
    	// теперь проверяем что изменилось
    	$total_topics = D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_forum_topics WHERE sid = '{$this->sid}' LIMIT 1");
    	$total_messages = D::$db->fetchvar("SELECT SUM(a.messages) FROM #PX#_forum_topics_stat a LEFT OUTER JOIN #PX#_forum_topics b USING (tid) WHERE b.sid = '{$this->sid}'");
    	$updater = array('topics' => $total_topics - $this->stat['topics'],
    	               'messages' => $total_messages - $this->stat['messages'],
    	                   'uid'  => $lastupdate['lastuid'],
    	               'username' => $lastupdate['lastusername'],
    	                  'title' => $lastupdate['title'],
    	                    'tid' => $lastupdate['tid'],
    	                 'update' => $lastupdate['lastupdate']);
    	$this->setUpdatedStat($updater,true);
    }


	function setUpdatedStat($updateInfo = array(), $force_update = false) {
		if($this->stat['lastupdate'] < $updateInfo['update'] || $force_update) {
			D::$db->exec("INSERT INTO #PX#_forum_sections_stat (sid, topics, messages, lasttid,lastuid, lastupdate, lastusername,lasttitle) VALUES
							('{$this->sid}',1,1,'{$updateInfo['tid']}','{$updateInfo['uid']}',UNIX_TIMESTAMP(),'{$updateInfo['username']}','{$updateInfo['title']}') ON DUPLICATE KEY UPDATE
		          lasttid = '{$updateInfo['tid']}', lastusername = '{$updateInfo['username']}', lastuid = '{$updateInfo['uid']}', lasttitle = '{$updateInfo['title']}',
	       	      lastupdate = '{$updateInfo['update']}', lastcomid = '{$updateInfo['comid']}', topics = topics + ({$updateInfo['topics']}), messages = messages + ({$updateInfo['messages']})");
		//видимо у нас удалили старые данные, в таком случае можно смело изменять счетчики а инфу о последних изменениях не трогать
		} else {
				D::$db->exec("INSERT INTO #PX#_forum_sections_stat (sid, topics, messages,lastupdate) VALUES ('{$this->sid}',1,1,UNIX_TIMESTAMP())
				ON DUPLICATE KEY UPDATE topics = topics + ({$updateInfo['topics']}), messages = messages + ({$updateInfo['messages']})");
		}
		if($this->parent_section) {
			$this->parent_section->setUpdatedStat($updateInfo,$force_update);
		}
		return true;
	}
}
?>
