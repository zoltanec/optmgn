<?php
class WrongSettingTypeException extends D_Core_Exception {

}
class Core_Settings extends D_Core_Object {
	public $default = '';
	static public $cacheself = 0;
	// реестр загруженных глобальных настроек сайта
	static protected $global_settings = false;
	static protected $settings_types = array("int","string","float","bool");
	// идентификатор настройки

	function __construct() {
		$this->lng_descr = $this->lng.'_DESCR';
	}

	static function getGlobalSettingsList() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_settings_types WHERE visibility = 'global'",__CLASS__);
	}

	static function __fetch($setting_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_settings_types WHERE setting_id = '{$setting_id}' LIMIT 1",__CLASS__);
	}


	protected function __save() {
		D::$db->exec("INSERT INTO #PX#_settings_types (setting_id,lng,type) VALUES ('{$this->setting_id}','{$this->lng}','{$this->type}')
		ON DUPLICATE KEY UPDATE lng = VALUES(lng), type = VALUES(type)");
		// сохраняем значение настройки
		return $this->setting_id;
	}

	function importFromObject($input) {
		if(in_array($input->type, self::$settings_types)) {
			$this->type = $input->type;
		// если тип не указан то используем первый из списка
		} else {
			throw new WrongSettingTypeException('Wrong setting type: '.$input->type);
		}
		$this->setting_id = $input->setting_id;
		$this->lng = $input->lng;
		// проводим разбор параметров
		// var_dump($setting);
	}

	function createDefault() {
		$value = D_Core_Factory::SettingValue($this->setting_id);
		$value->value = $this->default;
		$value->save();
	}
}
?>