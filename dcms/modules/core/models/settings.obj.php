<?php
class WrongSettingTypeException extends D_Core_Exception {

}
class Core_Settings extends D_Core_Object {
	// идентификатор настройки
	public $setting_id;
	public $object_id;
	public $type;
	public $lng;
	public $descr;
	public $value;
	static public $cacheself = 1;
	
	// реестр загруженных глобальных настроек сайта
	static protected $global_settings = false;
	static protected $settings_types = array("int","string","float","bool");
	
	function __construct() {
		if(!$this->object_id)
			$this->object_id = 'global';
    }

	static function getGlobalSettingsList() {
		return D::$db->fetchobjects("SELECT * FROM st_core_settings_types a 
												LEFT OUTER JOIN  st_core_settings_values b 
												USING(setting_id) 
												WHERE visibility = 'global'",__CLASS__);
	}

	static function __fetch($setting_id, $object_id='global') {
		return D::$db->fetchobject("SELECT * FROM #PX#_core_settings_types a 
												LEFT OUTER JOIN  #PX#_core_settings_values b 
												USING(setting_id) 
												WHERE setting_id = '{$setting_id}' AND object_id = '{$object_id}' LIMIT 1",__CLASS__);
	}
	
	protected function __object_id() {
		return array($this->setting_id, $this->object_id);
	}

	protected function __save() {
		D::$db->exec("INSERT INTO #PX#_core_settings_types (setting_id,lng,type,descr) 
			VALUES ('{$this->setting_id}','{$this->lng}','{$this->type}','{$this->descr}')
			ON DUPLICATE KEY UPDATE lng = VALUES(lng), type = VALUES(type), descr = VALUES(descr)");
		$setting = D_Core_Factory::Core_SettingValue($this, $this->object_id);
		
		$setting->save();
		// сохраняем значение настройки
		return $this->setting_id;
	}
	
	//TODO сделать проверку перезаписываемости
	public function importFromObject($setting) {
		if(in_array($setting->type, self::$settings_types)) {
			foreach($setting as $property=>$value){
				$this->{$property} = $value;
			}
			//Берем новое значение по умолчанию и сохраняем
			//Core_SettingValue::import($this, $this->object_id);
			$this->save();
		// если тип не указан то используем первый из списка
		} else {
			throw new WrongSettingTypeException('Wrong setting type: '.$setting->type);
		}
	}
	
	static function getAllSettings() {
		return D::$db->fetchobjects("(SELECT * FROM #PX#_core_settings_types a 
												   LEFT OUTER JOIN  #PX#_core_settings_values b 
												   USING(setting_id) WHERE object_id='global')
												   UNION
												   (SELECT * FROM #PX#_core_settings_types a 
												   LEFT OUTER JOIN  #PX#_core_settings_values b 
												   USING(setting_id) ORDER BY object_id)",__CLASS__);
	}
	
	//Удалить настройки модуля перед импортом
	static function deleteModuleSettings($module) {
		D::$db->exec("DELETE FROM #PX#_core_settings_types WHERE setting_id LIKE 'site.$module%'");
		D::$db->exec("DELETE FROM #PX#_core_settings_values WHERE setting_id LIKE 'site.$module%'");
	}
}
?>