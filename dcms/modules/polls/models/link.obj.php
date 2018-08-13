<?php
class Polls_Link extends D_Core_Object {

	public $lid;						//идентификатор линка.
	public $object_id='';				//человеко четабельный айди объекта к которому осуществляетца привязка
	public $resource_id = '';			//человеко четабельный айди объекта который привязываетца.

	protected function __object_id() {
		return array($this->lid);
	}
	
	static function __fetch($lid = 0 ) {
		return D::$db->fetchobject("SELECT * FROM #PX#_polls_links WHERE lid = '{$lid}' LIMIT 1",__CLASS__);
	}

	static function get_all_linked_resource($object_id) {
		return D::$db->fetchobjects("SELECT * FROM #PX#_polls_links WHERE object_id = '{$object_id}'",__CLASS__);
	}

	static function get_object_by_resource($resource_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_polls_links WHERE resource_id = '{$resource_id}' LIMIT 1",__CLASS__);
	}

	static function delete_link_with_all_linked_resources($object_id) {
		
		foreach ( Polls_Link::get_all_linked_resource($object_id) as $link ) {
		
			$file_obj = D_Core_Factory::getByID($link->resource_id);
			$file_obj->delete();
		}
		
		
		return D::$db->fetchobjects("DELETE FROM #PX#_polls_links WHERE object_id = '{$object_id}'",__CLASS__);
	}
	
	
	
	protected function __save() {
		if ( $this->object_id != '' && $this->resource_id != '' ) {
			
			$this->lid = D::$db->exec("INSERT INTO #PX#_polls_links (object_id, resource_id) VALUES ('{$this->object_id}', '{$this->resource_id}')");
		}
		return array($this->lid);
	}
}