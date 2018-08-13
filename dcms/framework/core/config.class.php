<?php
/**
 * Базовый класс конфигурации
 * TODO theme где-то берется из конфигурации. а гдето из D::theme()
 *  ...
 * @author desktop
 *
 */
class D_Core_Config implements ArrayAccess {
	//!Конфигурация cms
	protected $cfg = array();
    protected $defaults = [];
	//! Используемый протокол
	protected $prl;
	//!Сохраняем конфигурацию в параметр класса $cfg
	/**
	 * @param array $cfg - конфигурация cms полученная из core.php
	 */
	function __construct(&$cfg) {
		$this->cfg = &$cfg;
		//if($_SERVER['SERVER_PORT']==80)
		//	$this->prl = 'http://';
		//else $this->prl = 'https://';
	}
    
    /**
	 * Load default settings for modules
	 */
	public function loadDefaultSettings(&$opts) {
		$this->defaults[] = $opts;
	}

	//!Получение параметра конфигурации
	/**
	 * Получаем параметр конфигурации по ключу, если такого параметра не существует,
	 * то пробуем получить параметр по умолчанию
	 * @param string $var - параметр конфигурации cms
	 */
	function __get($var) {
		if($var == 'setting' || preg_match('/^obj_/', $var)) {
			$setting = new Core_SettingValue();
			if(preg_match('/^obj_/', $var))
				$setting->object_id = preg_replace('/^obj_/', '', $var);
			return $setting;
		} elseif(isset($this->cfg[$var])) {
			return $this->cfg[$var];
		} else {
            $p_var = str_replace('.','_', $var);
			if(method_exists($this, "__default_$p_var")) {
				return $this->{$var} = call_user_func(array(&$this,"__default_{$p_var}"));
			} else {
				foreach($this->defaults AS &$opts) {
					if(isset($opts[$var])) {
						return $this->{$var} = $opts[$var];
					}
				}
				return false;
			}
		}
	}
    
	//!Установка параметру конфигурации определенного значения
	/**
	 * @param string $var - параметр конфигурации cms
	 * @param mixed $value - значение параметра конфигурации
	 */
	function __set($var, $value) {
		if(method_exists($this, "__set_".$var)) {
			$this->cfg[$var] = call_user_func(array(&$this, "__set_".$var),array($value));
		} else {
			$this->cfg[$var] = $value;
		}
	}
	//!Проверяем есть ли такой конфигурационный параметр
	/**
	 * @param string $var - имя переменной
	 */
	function __isset($var) {
		if(isset($this->cfg[$var]) OR method_exists($this,"__default_".$var)) {
			return true;
		} else return false;
	}

	/**
	 * Функции для работы в режиме массива
	 */
	function offsetExists($offset) {
		return __isset($offset);
	}
	function offsetGet($offset) {
		return $this->{$offset};
	}
	function offsetSet($offset,$value) {
		return false;
	}
	function offsetUnset($offset) {
		return false;
	}
	//! Путь по умолчанию к серверу, где находятся общие скрипты, css, картинки
	private function __default_cdn_hostname() {
		return 'http://cdn.dinix.ru';
	}
	//! Путь по умолчанию к общим для всех проектов js скриптов на сервере
	private function __default_cdn_jscripts() {
		return $this->cdn_hostname."/jscripts";
	}
	//! Путь по умолчанию к общим для всех проектов картинкам на сервере
	private function __default_cdn_images() {
		return $this->cdn_hostname."/images";
	}
	//! Корень сайта по умолчанию
	private function __default_web() {
		return 'http://'.$_SERVER['SERVER_NAME'];
	}
	//! Путь по умолчанию к темам от корня сайта
	private function __default_themes_path() {
		return $this->web."/themes";
	}
	//! Путь по умолчанию к js скриптам от корня сайта
	private function __default_jscripts_path() {
		return $this->web."/jscripts";
	}
	//! Путь по умолчанию к контенту от корня сайта
	private function __default_content_path() {
		return $this->web."/content";
	}
	//! Путь по умолчанию к директории смайлов от корня сайта
	private function __default_smiles_path() {
		return $this->themes_path."/".D::theme()."/images/smiles";
	}
	//! Путь по умолчанию к директории виджетов
	private function __default_widgets_path() {
		return array($this->path."/widgets");
	}

	//! Путь по умолчанию к директории контента
	private function __default_content_dir() {
		return $this->path."/content";
	}
	//! Путь по умолчанию к директории js скриптов
	private function __default_jscripts_dir() {
		return $this->path."/jscripts";
	}
	//! Путь по умолчанию к директории которая используется в работе движка
	private function __default_work_dir() {
		return $this->path."/work";
	}

	private function __default_themes_dir() {
		return $this->path."/themes";
	}

	private function __default_theme_dir() {
		return $this->path."/themes/".$this->__get("theme");
	}

	private function __default_sys_content_dir() {
		return $this->path."/content";
	}
	private function __default_sys_content_path() {
		return $this->web."/content";
	}

	//! Имя по умолчанию для переменной сессии пользователя
	private function __default_users_session_var() {
		return 'default_site_user';
	}
	//!Имя по умолчанию для долгой cookie сессии пользователя
	private function __default_users_cookie_name() {
		return 'default_users_cookie';
	}

	/**
	 * Dir for default smarty lib directory
	 */
	protected function __default_smarty_dir() {
		return $this->dcms_path."/framework/smarty/Smarty-3.0rc3";
	}

	/**
	 * Do we need user object for site work
	 */
	private function __default_users_needed() {
		return false;
	}

	private function __default_request_offset() {
		return 0;
	}

	//!Имя сайта по умолчанию, используется в различных формах
	private function __default_site_name() {
		return 'Unknown site';
	}

	//!Язык системы по умолчанию, если не указан то используется первый язык из набора как опорный
	private function __default_default_language() {
		if(is_array($this->languages)) {
			return $this->languages[0];
		} else {
			return 'en';
		}
	}

	//!Поддерживаемые движком языки
	private function __default_languages() {
		return array('ru','en');
	}

	//!Проверка используется ли многоязычность
	private function __default_multilang() {
		return false;
	}
	//!Тема сайта по умолчанию
	private function __default_theme() {
		return 'default';
	}
	//!Смайлы по умолчанию
	private function __default_smiles_list() {
		return array();
	}

	private function __default_need_user() {
		return true;
	}
	//!Путь к шаблонизатору смарти по умолчанию
	private function __default_templates_work_dir() {
		return $this->work_dir."/smarty";
	}

	private function __default_online_stat_active() {
		return false;
	}

	private function __default_comments_active() {
		return true;
	}
	//!Параметр "только чтение" для коментариев, по умолчанию false
	private function __default_comments_readonly() {
		return false;
	}
	//!Драйвер базы данных по умолчанию
	private function __default_db_driver() {
		return 'mysql';
	}
	private function __default_databases() {
		return NULL;
	}
	private function __default_dump_exceptions() {
		return false;
	}

	private function __default_mailer() {
		return false;
	}
	private function __default_jquery_source() {
		return 'yandex';
	}

	//!Стандартные параметры настройки
	private function __default_debug() {
		return false;
	}
	//!Префикс кэша по умолчанию
	private function __default_cache_prefix() {
		return substr(md5($this->web), 0, 6);
	}
	//!модуль по умолчанию
	private function __default_default_module() {
		return 'index';
	}

	private function __default_long_cookie_sessions() {
		return true;
	}
	/**
	 * Default geoip path
	 */
	private function __default_geoip_dir() {
		return $this->path."/geoip";
	}

	//Редирект по умолчанию после авторизации
	private function __default__auth_redirect() {
		return '/index';
	}
	//!Режим переопределения экшенов
	/**
	 * Без этого параметра размещение измененных
	 * контроллеров в каталоге path/local/#MODNAME# не будет возможно
	 */
	private function __default_sys_core_allow_actions_override() {
		return false;
	}

	/**
	 * Use Templates View
	 */
	private function __default_sys_core_tpl() {
		return true;
	}

	private function __default_sys_core_redirect_on_denied() {
		return false;
	}
	/**
	 * List of modules allowed on this site
	 *
	 */
	private function __default_allow_modules() {
		return NULL;
	}

	/**
	 * List of modules denied on this site
	 *
	 */
	private function __default_deny_modules() {
		return NULL;
	}

	function __call($method, $variables) {
		return false;
	}
	//!Проверка, указана ли база данных
	function getHaveDatabases() {
		return isset($this->cfg['databases']);
	}
}
?>