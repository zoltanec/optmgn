<?php
/**
 * Settings types
 *
 */
class Core_SettingValue extends D_Core_Object {
	// unique setting id
	public $setting_id = '';
	// cache settings
	static public $cacheself = 0;
	// loaded global settings
	static protected $global_settings = NULL;

	/**
	 * Load global settings in static variable
	 */
	static function __getGlobalSettings() {
		return D::$db->fetchobjects_clear("SELECT a.* FROM #PX#_settings_values a WHERE a.object_id = 'global'",__CLASS__);
	}

	static function val($setting_id, $object_id = 'global') {
		$setting = D_Core_Factory::SettingValue($setting_id, $object_id);
		return $setting->value;
	}

	static function __fetch($setting_id, $object_id = 'global') {
		if($object_id == 'global') {
			if( self::$global_settings == NULL ) {
				self::$global_settings = self::getGlobalSettings();
			}
			if(is_array(self::$global_settings) && isset(self::$global_settings[$setting_id])) {
				return self::$global_settings[$setting_id];
			}
		}
		$object = D::$db->fetchobject("SELECT * FROM #PX#_settings_values WHERE setting_id = '{$setting_id}' LIMIT 1",__CLASS__);

		if(!is_object($object)) {
			$object = new self();
			$object->setting_id = $setting_id;
			try {
				$setting = D_Core_Factory::Settings($setting_id);
			} catch (Exception $e) {

				return NULL;
			}
			$object->value = $setting->default;
		}
		return $object;
	}
	function __save()  {
		D::$db->exec("INSERT INTO #PX#_settings_values (setting_id,object_id,value) VALUES ('{$this->setting_id}','global','{$this->value}') ON DUPLICATE KEY UPDATE value = VALUES(value)");
		return $this->setting_id;
	}
}
?>