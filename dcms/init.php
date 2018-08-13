<?php
class dStartupException extends Exception {
	public $userLevel = true;
}

abstract class D_Core_Runner {
	/**
	 * Карта классов. Массив содержащий значения вида имякласса-путькфайлу.
	 */
	public static $db;
	//! templates engine
	public static $Tpl;
	public static $tpl;

	//!путь к сайту web
	public static $web;
	//!путь к текущему модулю
	public static $web_module = '';

	public static $cache;
	public static $config;
	public static $path = '';
	public static $framework = '';
	public static $content = '';
	public static $content_path = '';
	public static $themes_path = '';
	public static $debug = true;
	public static $module = '';
	public static $modules_path = '';
	//!путь к автоматически загружаемым классам
	public static $autoload_path = array('%sitepath%/modules/%module%/objects/%classname%.obj.php',
										'%cmspath%/modules/%module%/objects/%classname%.obj.php',
										'%cmspath%/classes/%classname%.class.php',
										'%sitepath%/core/class/%classname%.class.php');

	public static $default_module = '';
	public static $req = '';
	public static $user = false;
	public static $theme = 'default';
	public static $cfg = array();
	public static $log;
	//!dCMS framework path
	public static $dcms_path = '';
	//!default modules search path
	public static $modules_search_path = array();
	//!В каких каталогах нада искать виджеты
	public static $widgetsSearchPath = array();
	public static $currentModule = '';
	public static $search_modules = array('core');

	/** окончена ли обработка запроса контроллером*/
	public static $is_request_finished = false;
	//!отслеживать в каких модулях сейчас находятся пользователи с помощью считалки статистики
	public static $onlineStatEnabled = true;
	//! объект статистики
	public static $online_stat = false;
	//!когда была запущена инициализация движка
	public static $starttime = 0;
	//!путь к виджетам
	public static $widgets_path = array();

	//! контекст , 0 - режим пользователя, 1 - режим администратора
	private static $context = 0;
	/**
	* @var string - Каталог в котором расположены коды шаблонизатора Smarty
	*/
	public static $smarty_dir = '';
	//!массив
	public static $T = array();

	//!массив автоматически загруженных классов
	public static $autoloaded_classes = array();

	//!источник шаблонов движка, находит необходимые шаблоны
	public static $templatesSource = false;

	//!объект локализации
	public static $i18n = false;
	//!обработчик сессий
	public static $session = false;


	/**
	 * Инициализация движка системы
	 *
	 * @param $cfg
	 */

	static function init($cfg) {
		//!время начала выполнения движка
		self::$starttime = microtime(1);
		spl_autoload_register(array('D','autoload'));
		//!для занесения данных в шаблон используем глобальную переменную
		self::$cfg = &$cfg;
		//!путь к ядру CMS
		self::$dcms_path  = dirname(__FILE__);
		self::$framework = self::$dcms_path.'/framework';


		self::$config = new D_Core_Config($cfg);

		self::$config->dcms_path = self::$dcms_path;

		self::$content_path = D::$config->content_dir;

		self::$smarty_dir = D::$config->smarty_dir;
		self::$path = D::$config->path;

		//!модифицируем каталог поиска модуля
		self::$modules_search_path = array(self::$path."/modules", self::$dcms_path."/modules");

		self::$cache = D::getCacher();
		//! check if we have any databases support
		if( D::$config->databases != NULL ) {
			$db = D::$config->databases['db'];
			$host = (isset($db['host'])) ? $db['host'] : 'localhost';
			self::$db = new D_Db_PDO($host, $db['user'], $db['password'], $db['name'], self::$cache, $db['prefix']);
		}
		self::$web = self::$config->web;
		self::$content = self::$config->content_path;
		self::$req = new D_Core_Request();
		self::$session = new D_Core_Session();

		if(D::$config->multilang) {
			D::$config->templates_work_dir.= "/".D::$req->lang;
			self::$web.= '/'.D::$req->lang;
		}

		self::$i18n = new D_Core_I18n(D::$req->lang);

		if(D::$config->{'sys.core.tpl'}) {
			self::$Tpl = new D_View_Tpl();
			self::$tpl = D::$Tpl;
			self::$widgets_path = D::$config->widgets_path;
			self::appendWidgetsPath(D::$config->widgets_path);
			self::$templatesSource = new D_View_Source();
			$wdgSrc = new D_View_Widget();
			//self::$online_stat = new D_Misc_Stat();
			self::$templatesSource->search_path = array(self::$path."/themes/".D::theme()."/templates/%module%/%filename%", "%modulepath%/templates/%filename%" );
			$wdgSrc->widgets_path = self::$widgets_path;
			self::$tpl->registration_list = [D::$templatesSource, &$wdgSrc, &self::$i18n];
		}

		self::$module = self::$req->module;
	}


	/**
	 * Get default site cacher
	 */
	static function getCacher() {
		switch(D::$config->cache) {
			case 'xcache': return new D_Cache_XCache(D::$config->cache_prefix);	break;
			case 'none':   return new D_Cache_Nullcache(D::$config->cache_prefix); break;
			default:	   return new D_Cache_Nullcache(D::$config->cache_prefix); break;
		}
	}

	/**
	 * Получаем пользователя
	 */
	static function getUser() {
		return Users_User::getSessionUser();
	}

	/**
	* Получаем список модулей
	*/
	static function getModulesList(){
		$modules_list = array();
		$supported_fields = array('name','version','descr');
		$i = 1;
		foreach(self::$modules_search_path AS $search_path) {
			$dir_files = scandir($search_path);
			unset($dir_files[0]);
			unset($dir_files[1]);
			$dir_modules = array();
			foreach($dir_files AS &$module) {
				$module_data = array('code' => $module, 'info' => array(), 'num' => $i);
				if(file_exists($search_path."/".$module."/info.txt")) {
					$info = file_get_contents($search_path."/".$module."/info.txt");
					$modinfo = array();
					foreach(explode("\n", $info) AS $line) {
						$data = explode(':', $line);
						if(sizeof($data) == 2 and in_array($data[0], $supported_fields)) {
							$modinfo[$data[0]] = $data[1];
						}
						//var_dump($data);
					}
					$module_data['info'] = $modinfo;
				}
				$i++;
				$dir_modules[] = $module_data;
			}
			$modules_list = array_merge($modules_list, $dir_modules);
		}
		return $modules_list;
	}

	/**
	 * Получаем список классов модуля
	 */
	static function getClassesList($module){
		$dir_files = scandir(self::getModulePath($module)."/models/");
		unset($dir_files[0]);
		unset($dir_files[1]);
		$classes=array();
		foreach($dir_files as $class){
			list($class)=explode(".",$class);
			$classes[]=$module."_".$class;
		}
		return $classes;
	}
	/**
	 * Получаем контекст выполнения
	 */
	static function getContext() {
		return (self::$context == 1 ) ? 'admin' : 'user';
	}
	static function setContext($context) {
		self::$context = ($context == 'admin') ? 1 : 0;
	}
	/**
	 * Get application language
	 */
	static function getLang() {
		return self::$lang;
	}

	/**
	 * Определяем тему оформления сайта
	 */
	static function theme() {
		return self::$config->theme;
	}


	/**
	 * Загружаем класс который не определен
	 * @param string $class_name - имя класса который необходимо загрузить;
	 */
	static function autoload($class_name) {
		$include_file = false;
		$cn_lower = strtolower($class_name);
		if(substr($class_name,0,2) == 'D_') {
			// разбиваем имя на части
			$include_file = self::$framework."/".str_replace('_','/',strtolower(substr($class_name,2))).".class.php";
		} elseif( strpos($cn_lower,'_') >= 2 && strpos($cn_lower, 'smarty_') === false ) {
			$class_path = explode('_', $cn_lower);
				$module_path = D::getModulePath($class_path[0]);
			if(empty($module_path)) {
				return false;
			}
			unset($class_path[0]);
			$include_file = $module_path."/models/".implode('/', $class_path).".obj.php";
			if(!file_exists($include_file))
				$include_file = self::$path."/work/".implode('/', $class_path).".obj.php";
		} elseif(substr($class_name,-6) === 'Widget') {
			//путь к файлу
			$filepath = "/".substr($cn_lower,0,-6)."/".$cn_lower.".php";
			foreach(self::$widgets_path AS $widget_path) {
				if(file_exists($widget_path.$filepath)) {
					$include_file = $widget_path.$filepath;
					break;
				}
			}
		} elseif(substr($cn_lower, 0, 16) === 'smarty_internal_' || $cn_lower == 'smarty_security') {
			$include_file =  D::$config->smarty_dir."/libs/sysplugins/{$cn_lower}.php";
		} elseif ($cn_lower == 'smarty') {
			$include_file = D::$config->smarty_dir."/libs/Smarty.class.php";
		} else {
			foreach(self::$autoload_path AS $path) {
				//преобразуем путь к необходимому виду
				foreach(self::$search_modules AS $module) {
					/** мы заменяем следующие переменные в путях
					* %module% - название модуля;
					* %classname% - название искомого класса
					* %cmspath% - путь к каталогу с основной частью CMS
					* %frameworkpath% - путь к фреймворку
					* %sitepath% - путь к каталогу сайта
					*/
					$parsed_path = str_replace(array('%module%', '%classname%', '%cmspath%', '%frameworkpath%', '%sitepath%'),
											   array($module, $cn_lower, self::$dcms_path, self::$framework, self::$path), $path);
					if(file_exists($parsed_path)) {
						$include_file = $parsed_path;
						break;
					}
				}
			}
		}

		if(file_exists($include_file)) {
			D::$autoloaded_classes[$class_name] = $include_file;
			include $include_file;
		} return false;
	}

	/**
	 * Система завершает свою работу. Здесь можно собрать статистику.
	 *  ...
	 */
	static function SysExit() {
	//	if(D::$config->online_stat_active) {
	//		D::$online_stat->TraceMe();
	//	}
		exit;
	}
	/**
	 * Указатель на то что обработка запроса контроллером закончена, ему ничего больше не надо, и предполагается что отображение уже выполнено
	 *
	 * @param int
	 */
	static function finishRequest() {
		self::$is_request_finished = true;
	}

	/**
	 * Get module path by it name
	 * By default we search modules in D::$modules_search_path directories.
	 *
	 * @param string $module_name - module name;
	 */
	static function getModulePath($module_name) {
		// check if module name is valid
		if(empty($module_name)) throw new D_Core_Exception("Empty module name", EX_MODULE_NOT_FOUND);
		$module_path = false;
		foreach(self::$modules_search_path AS $test_module_path) {
			if(is_dir($test_module_path."/".$module_name)) {
				return $test_module_path.'/'.$module_name;
			}
		}
		throw new D_Core_Exception("Module {$module_name} not found", EX_MODULE_NOT_FOUND);
	}

	static function getWidgetPath($widgetName) {
		$widgetPath = false;
		foreach(self::$widgetsSearchPath AS $testWidgetPath) {
			if(is_dir($testWidgetPath."/".$widgetName)) {
				$widgetPath = $testWidgetPath.'/'.$widgetName;
				break;
			}
		}
		return $widgetPath;
	}

	static function getSearchModules() {
		return self::$search_modules;
	}
	static function appendModuleNamespace($module) {
		D::$search_modules[] = $module;
	}
	static function appendAutoloadPath($path) {
		D::$autoload_path[] = $path;
	}
	static function getLoadedFiles() {
		return array_values(self::$autoloaded_classes);
	}

	static function appendWidgetsPath($path) {
		if(is_array($path)) {
			self::$widgetsSearchPath = array_merge(self::$widgetsSearchPath, $path);
		} else {
			self::$widgetsSearchPath[] = $path;
		}
		return true;
	}

	/**
	 * Some data which we need to dump, associated with request
	 *
	 * @param unknown_type $data
	 */
	static function dump($data, $class = 'default') {
		$dump_dir = D::$config->work_dir."/dumps/".$class;

		if(!is_dir($dump_dir)) {
			mkdir($dump_dir,0777,true);
		}

		$dump_file = $dump_dir."/".D::$req->getRequestId();

		if(file_exists($dump_file)) {
			$file = fopen($dump_file,'a');
			fwrite($file, "\n".str_repeat("=", 20)."\n", $data);
			fclose($file);
		} else {
			file_put_contents($dump_file, $data);
		}
		return true;
	}

	/**
	 * Запускаем систему, инициализируем переменные и стартуем контроллеры
	 */
	static function run() {
		$GLOBALS['T'] = array();
		global $T;
		try {
			// check for forbidden or denied modules
			D::$currentModule = self::$req->module;
			if( ( is_array(D::$config->allow_modules) && !in_array(D::$currentModule, D::$config->allow_modules)) ||
				( is_array(D::$config->deny_modules ) &&  in_array(D::$currentModule, D::$config->deny_modules ))) {

				if(D::$config->{'sys.core.redirect_on_denied'}) {
					D::$tpl->RedirectPermanently('/');
				}

				D::$tpl->show500('core;exceptions/ModuleDeniedException');
			}


			//проверяем есть ли у нас такой модуль
			if($modulePath = D::getModulePath(D::$currentModule)) {
				//указываем веб путь к модулю
				D::$web_module = D::$web."/".D::$currentModule;
				self::appendModuleNamespace(self::$req->module);
				//так же указываем откуда дергать шаблоны

				if(D::$config->{'sys.core.tpl'}) {
					self::$templatesSource->appendSource($modulePath."/templates/%filename%");
					self::$tpl->redirect_base = "/".D::$currentModule;
					self::$tpl->widgets_path = self::$widgets_path;
				}

				if(D::$config->users_needed) {
					//загружаем информацию о пользователе
					self::$user = D::getUser();

					if(!is_object(self::$user)) {
						self::$user = false;
					}

					// flush cache if needed
					if(D::$req->flush_cache == 'Y' && self::$user->hasRight('admin://panel/flush-cache/')) {
						self::$cache->flush = true;
					}
				} else {
					D::$user = false;
				}


				if(file_exists($modulePath."/init.php")) {
					require_once $modulePath."/init.php";
				}
				//проверяем указано ли действие
				if(!empty(self::$req->action)) {
					//выбранное действие
					$requested_action = D::$req->action;
					//если указано дефолтное действие модуля, то загружаем его
				} elseif (isset($default_action)) {
					D::$req->action = $requested_action = $default_action;
				} else {
					D::$req->action = $requested_action = 'index';
				}
                if(!file_exists($modulePath."/src/{$requested_action}.php")) {
                    // we use index action by default
                    $requested_action = (isset($default_action)) ? $default_action : "index";
                }
				// if we use actions override, then we need to check local dir
				$override_file = D::$path."/local/".D::$currentModule."/src/".$requested_action.".php";
                
				if(D::$config->{'sys.core.allow_actions_override'} && file_exists($override_file)) {
					require $override_file;
				} else {
					require_once $modulePath."/src/".$requested_action.".php";
				}
				// по умолчанию отображается шаблон который имеет такое же имя как и действие
				// при обработке запросов из аякса рендерим только то что надо
				if(D::$req->isAjax()) {
					self::$Tpl->setClearRendering();
				}
				self::$Tpl->show('dit:'.D::$currentModule.";{$requested_action}");
			} else {
				throw new D_Core_Exception("Module ".D::$req->module." not found.", EX_MODULE_NOT_FOUND);

			}
			D::sysExit();
		} catch (Exception $e) {
			$T['e'] = &$e;
			if(D::$config->dump_exceptions) {
				if(!is_dir(D::$config->work_dir."/exceptions")) {
					mkdir(D::$config->work_dir."/exceptions");
				}
				$exception_name = strftime('%Y-%m-%d_at_%H%M',time())."_".substr(md5(rand()),0,6);
				$exception_file = D::$config->work_dir."/exceptions/".$exception_name;
				if(method_exists($e, 'dump') && is_writable(dirname($exception_file))) {
					$e->dump($exception_file);
				}
			}
			// делаем дамп исключения
			if(D::$config->debug) {
				if(D::$Tpl->rendering_started) {
					D::$Tpl->RenderTpl('dit:core;exceptions/'.get_class($e));
				} else {
					D::$Tpl->show('dit:core;exceptions/'.get_class($e));
				}
			} else {

				if(D::$Tpl->rendering_started) {
					D::$Tpl->RenderTpl('dit:core;exceptions/UserException');
				} else {
					D::$Tpl->show('dit:core;exceptions/UserException');
				}
			}
		}
	}
}
?>
