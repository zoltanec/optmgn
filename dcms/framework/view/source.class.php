<?php
/**
 *
 * Класс для получения доступа к шаблонам системы
 * @author desktop
 *
 */
class D_View_Source {
	//!каталоги в которых производится поиск шаблонов
	public $search_path = array();
	//!таблица найденных шаблонов
	private $found = array();
	protected $previousModule = false;
	//!Преобразуем имя шаблона в реальный адрес
	/**
	 *
	 * Преобразуем имя шаблона в реальный адрес
	 * @param string $tpl_name - имя шаблона
	 */
	function map_name($templateName) {
		if($templateName[0] == '/') {
			return $templateName;
		}
		if(substr($templateName, -4) != '.tpl') {
			$templateName .= '.tpl';
		}
		//var_dump($this->search_path);exit;
		//вычисляем кэш шаблона
		$tpl_hash = md5($templateName);
		//если мы не знаем какой шаблон надо выбрать для определения местоположения файла
		if(isset($this->found[$tpl_hash])) {
			return $this->found[$tpl_hash];
		} else {
			if(strpos($templateName,';') === false) {
				if($this->previousModule AND D::$currentModule != $this->previousModule) {
					$modules = array(D::$currentModule, $this->previousModule);
				} else {
					$modules = array(D::$currentModule);
				}
				$filename = $templateName;
			} else {
    			list($module,$filename) = explode(";",$templateName);
    			$modules = array($module);
			}
			$modules = array_merge($modules, D::getSearchModules());
    		//обходим массив каталогов для поиска
    		foreach($this->search_path AS $path) {
    			foreach($modules AS $module) {
    				$realname = str_replace(array('%module%','%filename%', '%modulepath%'), array($module,$filename,D::getModulePath($module)),$path);
    				if(file_exists($realname)) {
    					$this->found[$tpl_hash] = $realname;
    					$this->previousModule = $module;
    					//echo $realname;
    					return $realname;
    				}
    			}
    		}
    		throw new D_Core_Exception("Template not found: ".$templateName);
    	}
	}

	function appendSource($string) {
		$this->search_path[] = $string;
	}
	/**
	 *
	 * Исходный код шаблона
	 * @param $tpl_name - имя файла шаблона
	 * @param $tpl_source
	 * @param $smarty
	 */
	function source($tpl_name, &$tpl_source = NULL, $smarty = NULL) {
   		//определяем реальное имя файла
   		$realname = $this->map_name($tpl_name);
   		//первым через ; идет указание модуля файла
    	if($realname) {
        	$tpl_source = $this->strip(file_get_contents($realname));
        	return true;
    	} else {
    		$tpl_source = '';
    		return true;
    	}
	}

	/**
	 *
	 * Время последней модификации шаблона
	 * @param $tpl_name
	 * @param $tpl_timestamp
	 * @param $smarty
	 */
	function timestamp($tpl_name, &$tpl_timestamp = NULL, $smarty = NULL) {
   		//определяем реальное имя файла
    	$realname = $this->map_name($tpl_name);
    	if($realname) {
        	$stat = stat($realname);
        	$tpl_timestamp = $stat['mtime'];
    	} else {
    		$tpl_timestamp = time();
    	}
    	return true;
	}

	function secure($tpl_name, $smarty) {
		return true;
	}


	function trusted($tpl_name, $smarty) {
    	return true;
    }

    function strip($tpl_source = '') {
    	if(!D::$config->{'sys.core.tpl_strip'}) return $tpl_source;

    	//ищем сообщения языка
    	$from = array('/>(\s+)</','/>(\s+)#([A-Z0-9\_]+)#/','/{\/([a-z0-9]+)}(\s+)/','/\s+<\/([a-z0-9]+)>/');
    	$to = array('><','>#\2#','{/\1}','</\1>');
    	return preg_replace($from, $to, $tpl_source);
    	//return $source;
    }

    /**
     *
     * Регистрируем наш объект как ресурс Smarty...
     * @param &$smarty - объект Smarty
     */
    function register(&$smarty) {
    	if(is_object($smarty)) {
    		//регистрируем объект как шаблон smarty
    		if(is_object($smarty->register)) {
    			//var_dump($smarty->register);exit;
    			$smarty->register->resource('dit', array(&$this,'source','timestamp','secure','trusted'));
    		} else {
    			$smarty->registerResource('dit', array(&$this,'source','timestamp','secure','trusted'));
    		}
    		$smarty->default_resource_type = 'dit';
    	} else trigger_error('Wrong object type for dTemplate register',E_USER_ERROR);
    }
}
?>
