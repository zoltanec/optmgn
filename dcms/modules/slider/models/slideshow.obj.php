<?php
define('NEWS_SLIDESHOW_MAIN_CT',600);
class Slider_Slideshow extends D_Core_Object {
	//идентификатор слайда
	public $ssid = 0;
	public $count = 0;
	public $getslides = 6;
	public $video = 1;
	//настройки кэширования
	//static protected $cacheable = array('slides'=> 600,'slidescount'=>600);
	static protected $cachestatic = array('listSlideshows' => 600, 'getAll'=>0);

	protected function __object_id() {
		return array('slideshow');
	}
	static function __fetch($ssid) {
		return D::$db->fetchobject("SELECT * FROM #PX#_slider_slideshow WHERE ssid = '{$ssid}' LIMIT 1",__CLASS__);
	}
	//сохранение
	function __save() {
		if($this->ssid == 0) {
            D::$db->exec("INSERT INTO #PX#_slider_slideshow (title,short,url,video) VALUES ('{$this->title}','{$this->short}','{$this->url}','{$this->video}')");
			//заносим идентификатор новости
			// $this->ssid = D::$db->insert_id();
		} else {
			D::$db->exec("UPDATE #PX#_slider_slideshow SET title = '{$this->title}', short = '{$this->short}',
														  active = '{$this->active}', url = '{$this->url}',
														priority = '{$this->priority}', image = '{$this->image}',
														   video = '{$this->video}'
														WHERE ssid = '{$this->ssid}' LIMIT 1");
		}
	}
	//отображаем слайды
	function __get_slides() {
		$count = 5;
		return D::$db->fetchobjects("SELECT * FROM #PX#_slider_slideshow WHERE active ORDER BY priority,ssid DESC LIMIT {$count}",__CLASS__);
	}
	function __get_slidescount() {
		return sizeof($this->slides);
	}
	//возвращаем все слайды
	function __get_all() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_slider_slideshow ORDER BY active, priority DESC",__CLASS__);
	}
	//загружаем все слайды в наш объект
	static function getActive() {
	//загружаем список слайдов
		return D::$db->fetchobjects("SELECT * FROM #PX#_slider_slideshow WHERE active ORDER BY priority DESC",__CLASS__);
	}

	static function getAllSlides() {
		//загружаем список слайдов
		return D::$db->fetchobjects("SELECT * FROM #PX#_slider_slideshow ORDER BY priority,ssid DESC",__CLASS__);
	}

	static protected function __listSlideshows($count) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_slider_slideshow WHERE active ORDER BY priority,ssid DESC LIMIT {$count}",__CLASS__);
	}
	function __delete() {
		D::$db->exec("DELETE FROM #PX#_slider_slideshow WHERE ssid = '{$this->ssid}' LIMIT 1");
		return $this->ssid;
	}
}
?>
