<?php
/*
 * Класс для рассширения существующих классов и для генерации новых классов и надстроек к ним
 */
class Core_Entity_iBlock extends D_Core_Object{
	public $block_id;
	//!id категории для которой создается надстройка
	public $sid;
	//!Название модуля
	public $module_name;
	//!Название класса
	public $class_name;
	//!Наследуемый класс
	public $parent_class_name;
	//!Описание блока
	public $descr;
	//!Время добавления
	public $add_time;
	//!Время последнего изменения
	public $upd_time;
	//!Идентификатор пользователя, создавшего сущность
	public $uid;
	//!Флаг активности
	public $active;
	
	static function __fetch($block_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_core_iblocks WHERE block_id={$block_id} LIMIT 1",__CLASS__);
	}
	function object_id() {
		return $this->block_id;
	}
	function delete() {
		D::$db->exec("DELETE FROM #PX#_core_iblocks WHERE block_id={$this->block_id} LIMIT 1");
		D::$db->exec("DELETE FROM #PX#_core_iblocks_properties WHERE block_id={$this->block_id}");
		//Удаляем таблицу со значениями
		//Удаляем модуль или файл с хренью
	}
	function save() {
		if(strpos($this->class_name,$this->module_name)===false)
			$this->class_name=$this->module_name."_".$this->class_name;
		if($this->block_id == 0) {
			$this->block_id=D::$db->exec("INSERT INTO #PX#_core_iblocks(
																	 module_name,
																	 class_name,
																	 parent_class_name, 
																	 sid, 
																	 `descr`
																	 )
															VALUES ('{$this->module_name}',
																	'{$this->class_name}',
																	'{$this->parent_class_name}',
																	'{$this->sid}', 
																	'{$this->descr}')");
		}
		else {
			D::$db->exec("UPDATE #PX#_core_iblocks SET  module_name = '{$this->module_name}',
														class_name = '{$this->class_name}',
														parent_class_name = '{$this->parent_class_name}',
														descr = '{$this->descr}',
														active = {$this->active},
														sid = {$this->sid} WHERE block_id={$this->block_id} LIMIT 1");
		}
		return $this->block_id;
	}
	function getKeys($out="list"){
		$keysobj=Core_Entity_Property::getKeys($this->block_id);
		$keys=array();
		foreach($keysobj as $key){
			$keys["list"][]=$key->prop_code;
			$keys["cond"][]=$key->prop_code."='{\$this->".$key->prop_code."}'";
		}
		return $keys[$out];
		
	}
	function getIncrementKey(){
		$keysobj=Core_Entity_Property::getKeys($this->block_id);
		$keys=array();
		foreach($keysobj as $key){
			if($key->increment)
				return $key->prop_code;
		}
	}
	function getProperties($out="list"){
		$properties=array();
		foreach(Core_Entity_Property::getProperties($this->block_id) as $property){
			if($out!="list")
			$properties[$out][]=$property->prop_code."='{\$this->".$property->prop_code."}'";
			else $properties[$out][]=$property->prop_code;
		}
		return $properties[$out];
	}
	function installDbTable(){
		$this->table_name="#PX#_{$this->class_name}";
		if($this->sid)
			$this->table_name.="_sid{$this->sid}";
		$query="DROP TABLE IF EXISTS {$this->table_name};
		CREATE TABLE {$this->table_name} (\n";
		foreach(Core_Entity_Property::getProperties($this->block_id) as $prop){
			$query.=$prop->prop_code." ".Core_Entity_Property::$types[$prop->prop_type];
			if($prop->prop_length)
			$query.="({$prop->prop_length})";
			$query.=" NOT NULL";
			if($prop->default)
			$query.=" {$prop->default}";
			if($prop->increment)
			$query.=" AUTO_INCREMENT";
			$query.=" COMMENT '{$prop->descr}',\n";
		}
		$query.="PRIMARY KEY(".implode(",",$this->getKeys()).")";
		$query.=") ENGINE='INNODB' COMMENT='{$this->descr}'";
		D::$db->exec($query);
		return true;
	}
	function getCreateModel() {
		$tpl="<?php\nclass {$this->class_name}";
		if($this->extend)
			$tpl.=" extends {$this->extend}{\n";
		else $tpl.=" extends D_Core_Object{\n";
		$tpl.="public $".implode(";\npublic $",$this->getProperties()).";\n"
			."static function fetch($".implode(",$",$this->getKeys())."){\n"
			."\treturn D::\$db->fetchobject(\"SELECT * FROM {$this->table_name} "
			."WHERE ".implode(" AND ",$this->getKeys("cond"))." LIMIT 1\",__CLASS__);\n"
			."}\n"
			."function delete(){\n"
			."\tD::\$db->exec(\"DELETE {$this->table_name} "
			."WHERE ".implode(" AND ",$this->getKeys("cond"))." LIMIT 1\");\n"//Тут надо переделать на $id='{$id}'
			."}\n"
			."function save(){\n";
			if(count($this->getKeys())>1 || !$this->getIncrementKey()){
					$key=array_shift($this->getKeys());
					$tpl.="\t\tD::\$db->exec(\"INSERT INTO {$this->table_name} ("
					.implode(",\n\t\t",$this->getProperties()).")\n"
					."\t\tVALUES('{\$this->".implode("}',\n\t\t'{\$this->",$this->getProperties())."}')\n"
					."\tON DUPLICATE KEY UPDATE ".implode(",\n\t\t",$this->getProperties("cond"))."\");\n";
			}else{
					$key=array_shift($this->getKeys());
					$tpl.="\tif(\$this->{$key}==0)\n"
					."\t\t\$this->{$key}=D::\$db->exec(\"INSERT INTO {$this->table_name} ("
					.implode(",\n\t\t",$this->getProperties()).")\n"
								."\t\tVALUES('{\$this->".implode("}',\n\t\t'{\$this->",$this->getProperties())."}')\");\n"
								."\telse D::\$db->exec(\"UPDATE {$this->table_name} SET ".implode(",\n\t\t",$this->getProperties("cond"))." WHERE {$key}='{\$this->{$key}}'\");\n"
								."\treturn \$this->{$key};\n";		
			}
			$tpl.="}\n"
			."static function getAll{$this->class_name}(){\n"
			."\treturn D::\$db->fetchobjects(\"SELECT * FROM {$this->table_name}\",__CLASS__);"
			."}\n"
			."}\n?>";
		return $tpl;
	}
	static function getBlocksByParent($parent_class_name){
		return D::$db->fetchobjects("SELECT * FROM #PX#_core_iblocks WHERE parent_class_name='{$parent_class_name}'",__CLASS__);
	}
	static function getAllBlocks(){
		return D::$db->fetchobjects("SELECT * FROM #PX#_core_iblocks ORDER BY module_name",__CLASS__);
	}
	//static function getChildProperties($object){
	//	$props=array();
	//	foreach(self::getBlocksByParent(get_class($object)) as $block){
	//		if(!isset($object->sid) || $object->sid==$block->sid){
	//			foreach (Core_Entity_Property::getProperties($block->block_id) as $property){
	//				$props["property"]=$property;
	//				$props["child_object"]=D_Core_Factory::$block->class_name($object->prod_id);
	//			}
	//		}
	//	}
	//}
	function getChildObject($object){
		$class_name=$this->class_name;
		return D_Core_Factory::$class_name($object->prod_id);
	}
}
?>