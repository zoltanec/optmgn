<?php
//!Класс обработки группы пользователя
class Users_Group extends D_Core_Object {

	//!Идентификатор группы
	public $gid;
	//!Имя группы
	public $group_name = '';
	//!Цвет отображения имён пользователей
	public $group_color = 0;

	//!Время кэширования
	//  static public $cacheself = 0;

	protected function __object_id() {
		return array($this->gid);
	}
	//!Получение объекта группы по gid
	/**
	* Метод возвращает группу в виде объекта класса
	*/
	function __fetch($gid) {
			return D::$db->fetchobject("SELECT * FROM #PX#_users_groups WHERE gid = {$gid} LIMIT 1", __CLASS__);
	}
	//!Сохранение и изменение группы
	/**
	* Метод возвращает gid созданной или измененной группы
	*/
 	function __save() {
		if($this->gid == 0 ) {
			 $this->gid = D::$db->exec("INSERT INTO #PX#_users_groups (group_name, group_color) VALUES ('{$this->group_name}',{$this->group_color})");
		} else {
			D::$db->exec("UPDATE #PX#_users_groups SET group_name = '{$this->group_name}',
											 group_color = '{$this->group_color}' WHERE gid = {$this->gid} LIMIT 1");
		}
		return $this->gid;
	}
	//!Получение всех групп
	/**
	* Метод возвращает массив групп в виде объектов класса
	*/
	static function getUsersGroups(){
		return D::$db->fetchobjects("SELECT * FROM #PX#_users_groups", __CLASS__);
	}
}
?>