<?php
/*
 * 
 *	Класс для создания модели сущности по его JSON
 */
class Core_Entity_Def {
	//!Название таблицы
	protected $entity_table_name;
	//!Название класса
	protected $entity_class_name;
	//!Описание сущности
	protected $entity_desc;
	//!Время добавления
	protected $add_time;
	//!Время последнего изменения
	protected $upd_time;
	//!Идентификатор пользователя, создавшего сущность
	protected $uid;
	//!Сортировка
	protected $sorting;
	//!Флаг активности
	protected $active;
	//!Поля сущности
	protected $entity_fields = array();
	
	function __construct($model_data){
		if(!is_array($model_data)) {
			$model_data = preg_replace("/#([^(#PX#_)].*?)(.*)\n|\n+/","",file_get_contents($model_data));
			$model_data = preg_replace("/\s\s+/","",$model_data);
		}
		$model_data = json_decode($model_data, true);
		if(json_last_error() != JSON_ERROR_NONE) {
			throw new D_Core_Exception("Wrong json file".json_last_error().$model_data);
			return false;
		}
		// название модели
		if(isset($model_data['entity_class_name'])) {
			$this->entity_class_name = $model_data['entity_class_name'];
		} else {
			return false;
		}

		//таблица контейнер
		if(isset($model_data['entity_table_name'])) {
			$this->entity_table_name = $model_data['entity_table_name'];
		} else {
			return false;
		}

		//поля таблицы
		if(isset($model_data['entity_fields'])) {
			$this->entity_fields = $model_data['entity_fields'];
		}

		if(isset($model_data['entity_desc'])) {
			$this->entity_desc = $model_data['entity_desc'];
		}
	}
	function getInstallDb() {
			$query="CREATE TABLE #PX#_entity_{$this->entity_table_name} (";
			foreach($this->entity_fields as $field){
				$query.=$field['field_name']." ".$field['field_type'];
				if($field['size'])
					$query.="({$field['size']})";
				if($field['not_null'])
					$query.=" NOT NULL";
				$query.=" ".$field['default'];
				if($field['autoincrement'])
					$query.=" AUTO_INCREMENT";
				$query.=" COMMENT '{$field['field_comment']}',";
				if($field['primary_key'])
					$primary_keys[]=$field['field_name'];
			}
			$query.="PRIMARY KEY(".implode(",",$primary_keys).")";
			$query.=") ENGINE='INNODB' COMMENT='{$this->entity_desc}'";
			var_dump($query);
			return $query;
	}
	function getCreateModel() {
		foreach ($descr as $data){
			preg_match($type_re, $row['Type'], $matches);
		}
		$template='class <{classname}> extended D_Core_Object{
					public <{field}>
					function __fetch(field){
						return D::$db->fetchobject("SELECT FROM #PX#_entity_ WHERE field=field LIMIT 1",__CLASS__);
					}
					function __delete(){
						D::$db->exec("DELETE #PX#_entity_ WHERE field={$this->field}");
					}
					function __save(){
						if($this->field==0)
							D::$db->exec(INSERT INTO #PX#_entity () VALUES());
						else D::$db->exec("UPDATE #PX#_entity SET WHERE field={$this->field}");
						return $this->field;
					}
					static function getAllclassname(){
						return D::$db->fetchobjects("SELECT FROM #PX#_entity_ ORDER BY LIMIT 1",__CLASS__);
					}
					}';
	}
	static function send() {
		return "fsffsdfsdf";
	}
}
?>