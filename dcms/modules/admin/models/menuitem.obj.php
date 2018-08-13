<?php
/**
<<<<<<< HEAD
 * Элементы меню в панели администратора
=======
 * Administrator panel elements
>>>>>>> unstable
 */

class Admin_MenuItem extends D_Core_Object {
	use D_Db_ActiveRecord;

	//идентификатор меню
	public $item_id = 0;
	//название пункта меню
	public $menu_name = '';
	//идентификатор ресурса
	public $uri = '';
	//активно ли меню
	public $active = 1;
	public $priority = 0;
	// cache settings
	static public $cacheself = 2;
	static public $cachestatic = array('getActiveMenus' => 30);

	static protected function __table() {
		return '#PX#_admin_menu_items';
	}
	static protected function __pk() {
		return ['item_id'];
	}
	static protected function __fields() {
		return ['menu_name', 'uri', 'active'];
	}

	//список активных меню администратора
	static protected function __getActiveMenus() {
		try {
			return D::$db->fetchobjects("SELECT * FROM #PX#_admin_menu_items WHERE active ORDER BY priority DESC",__CLASS__);
		} catch( Exception $e) {
			return array();
		}
	}

	static protected function __getAllMenus() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_admin_menu_items ORDER BY priority DESC",__CLASS__);
	}

	/**

	static public function __fetch($item_id = 0) {
		return D::$db->fetchobject("SELECT * FROM #PX#_admin_menu_items WHERE item_id = '{$item_id}' LIMIT 1",__CLASS__);
	}

	function delete() {
	  D::$db->exec("DELETE FROM #PX#_admin_menu_items WHERE item_id = '{$this->item_id}' LIMIT 1");
	}

	 * protected function __save() {

		if($this->item_id == 0 ) {
			$this->item_id = D::$db->exec("INSERT INTO #PX#_admin_menu_items (menu_name, uri,active) VALUES ('{$this->menu_name}', '{$this->uri}', false)");
		} else {
			D::$db->exec("UPDATE #PX#_admin_menu_items SET menu_name = '{$this->menu_name}', priority = '{$this->priority}', active = '{$this->active}', 			                                                     uri = '{$this->uri}'
			                                                   WHERE item_id = '{$this->item_id}' LIMIT 1");
		}
		return $this->item_id;
	}

	protected function __object_id() {
		return array($this->item_id);
	}*/
}
?>
