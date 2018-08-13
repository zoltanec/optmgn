<?php
class Pages_StaticPagesList extends D_Core_List {
	public $container = 'Pages_StaticPage';
	public $order = 'reverse';
	public $pagecaching = array('full' => 60, 'unfinished' => 50);
	static public $perpage = 50;
	
	function __construct(){
		$this->fetch_query = 'SELECT /*COLS*/*/*/COLS*/ FROM #PX#_static_pages ORDER BY add_time';
		$this->perpage(self::$perpage);
	}
}
?>