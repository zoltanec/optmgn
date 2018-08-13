<?php
/**
 * Settings types
 */
class Core_SettingValue extends D_Core_Object {
	// unique setting id
	public $setting_id = '';
	public $value = '';
	public $object_id = 'global';
	static public $module;
  static public $object;
	// cache settings
	static public $cacheself = 0;
	// loaded global settings
	static protected $global_settings = NULL;

	function __construct() {
		//Если не указан конкретный модуль, 
		//берем из запроса
		if(!self::$module){
			if(isset(D::$req->module)) {
				$this->module = D::$req->module;
				if(D::$req->module == 'admin' && D::$req->action == 'run') {
					$this->module = D::$req->textID('param1');
				}
			}
		} else {
			$this->module = self::$module;
		}
	}
	
	// Magic method for get settings
	function __get($var) {
		$this->setting_id = 'site.' . $this->module . '.' . $var;
		try {
			$setting = D_Core_Factory::Core_SettingValue($this->setting_id, $this->object_id);
			return $setting->value;
		} catch (Exception $e) {
			return false;
		}
	}

	static function __fetch($setting, $object_id = 'global') {
		$setting_id = $setting;
		if(is_object($setting))
			$setting_id = $setting->setting_id;
		
		//if($setting_id == 'site.feedback.phone') {
		//if($object_id == 'question'){
		//	var_dump($setting);exit;
		//}
		//Для глобальных настроек вытягиваем из кэша
		if($object_id == 'global') {
			if( self::$global_settings == NULL ) {
				self::$global_settings = self::getGlobalSettings();
			}
			if(is_array(self::$global_settings) && isset(self::$global_settings[$setting_id])) {
				$object = self::$global_settings[$setting_id];
			}
		} else {
			$object = D::$db->fetchobject("SELECT * FROM #PX#_core_settings_values WHERE setting_id = '{$setting_id}' and object_id = '{$object_id}' LIMIT 1",__CLASS__);
		}
		//При создании настройки
		if(is_object($setting) && !$object){
			$object = new self();
			$object->setting_id = $setting->setting_id;
			$object->object_id = $setting->object_id;
			$object->value = $setting->default;
		}
		
		//Если нет объекта
		if(!isset($object)) {
			if (D::$config->debug == true)
				throw new D_Core_Exception('Not such setting: '. $setting_id, EX_OTHER_ERROR);
			else 
				return false;
		} else {
			//Если сохраняем новое значение до берем из входных параметровы
			if(isset($setting->value)) {
				$object->value = $setting->value;
			}
		}
		return $object;
	}
	
	static function import($setting, $object_id) {
			//Инициализация новой настройки значением по умолчанию
			
	}
	
	protected function __save()  {
		D::$db->exec("INSERT INTO #PX#_core_settings_values (setting_id,object_id,value) VALUES ('{$this->setting_id}','{$this->object_id}','{$this->value}') ON DUPLICATE KEY UPDATE value = VALUES(value)");
		return $this->setting_id;
	}
	
	/**
	 * Load global settings in static variable
	 */
	static function __getGlobalSettings() {
		//return massive like $settings['setting_id']
		return D::$db->fetchobjects_clear("SELECT a.* FROM #PX#_core_settings_values a WHERE a.object_id = 'global'",__CLASS__);
	}

	//Light method for get global setting
	static function getValue($setting_id, $object_id = 'global') {
		$setting = D_Core_Factory::Core_SettingValue($setting_id, $object_id);
		return $setting->value;
	}
	
}
?>