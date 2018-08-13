<?php
/**
 * Обработка списков новостей
 */
class NewsList extends D_Core_List {
	static protected $cacheable = array('total'=> 4);
	//запрос для получения информации из базы
	//public $NewsFetchQuery = '';
	//контейнер который хранит результаты работы со списком
	var $container = 'News';
	function __construct($object_id = '') {
		//$this->NewsFetchQuery = new dQuery("SELECT a.title,a.nid,a.sid,a.source,a.addtime,c.readed, a.icon, c.comments,a.active FROM #PX#_news a
		//LEFT OUTER JOIN #PX#_news_stat c USING (nid) #WHERE# ORDER BY a.nid ASC");
	}


	public function __get_total() {
		$count = D::$db->fetchline("SELECT COUNT(1) as count FROM #PX#_news");
		return ($count['count'] > 0) ? $count['count'] : 0;
	}
	/**
	 * Получить список всех новостей из архива
	 * @param unknown_type $page
	 * @param unknown_type $perpage
	 * @param unknown_type $order
	 */
	static function &all($page = 'first',$perpage = 100, $order = 'reverse') {
		$list = new News_NewsList('all');
        //страница для отображения
		$list->order("reverse")->perpage($perpage);
		$list->fetch_query = $list->NewsFetchQuery;
		return $list;
	}
}
?>