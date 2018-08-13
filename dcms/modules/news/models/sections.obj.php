<?php
class News_Sections extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $sid = 0;
	public $section_key = 'all';
	static public $cacheself = 100;

    static protected function __pk() {
    	return ['sid'];
    }

    static protected function __fields() {
    	return ['section_name', 'section_key', 'descr', 'priority'];
    }

    static function all() {
        $section = new self();
        $section->sid = 'all';
        return $section;
    }

    //получение новостных разделов
    static function getAllSections() {
        return D::$db->fetchobjects("SELECT * FROM #PX#_news_sections ORDER BY priority ASC",__CLASS__);
    }

    //магическая функция получения несуществующих переменных
    function __get_news() {
    	return News_News::sectionNews($this->sid,$this->page,$this->perpage);
    }

    static public function __fetch($section_needed = 0) {
    	if($section_needed == 'all') {
    		return self::all();
    	}

    	if(is_int($section_needed)) {
    		return self::find( [ 'sid' => intval($section_needed) ], ['limit' => 1] );
    	} else {
    		return self::find( [ 'section_key' => $section_needed ], ['limit' => 1] );
    	}
    }

    function getNewsList() {
    	if($this->sid == 'all') {
    		return News_News::getSearchList(['active' => 1]);
    	} else {
    		return News_News::getSearchList(['sid' => $this->sid, 'active' => 1]);
    	}
    }
}
?>