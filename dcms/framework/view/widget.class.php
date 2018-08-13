<?php
/**
 * Управление виджетами сайта
 *
 */
class D_View_Widget {
	public $widgets_path = array();
	/**
	 * Преобразуем имя виджета в адрес файла виджета
	 * @param string $widget_name - имя подключаемого виджета.
	 */
	function map_name($tpl_name) {
		if(strpos($tpl_name, ';') != 0) {
			list($widget_name, $template_name) = explode(";",$tpl_name);
			//разрешаем упускать расширение
			if(substr($template_name, -4) != '.tpl') {
				$template_name .= '.tpl';
			}
			foreach($this->widgets_path AS $path) {
				if(is_dir($path."/".$widget_name)) {
					return $path."/".$widget_name."/".$template_name;
				}
			}
		} else {
			$widget_name = $tpl_name;
			//ищем путь к виджету
			foreach($this->widgets_path AS $path) {
				if(is_dir($path."/".$widget_name)) {
					return $path."/".$widget_name."/template.tpl";
				}
			}
		}
	}
	/**
	 *
	 * Исходный код шаблона
	 * @param string $tpl_name - имя файла шаблона;
	 * @param string &$tpl_source - переменная куда будет записан шаблон;
	 * @param Smarty &$smarty - объект шаблонизатора;
	 */
	function source($tpl_name, &$tpl_source, $smarty) {
   		//определяем реальное имя файла
   		$realname = $this->map_name($tpl_name);
   		//первым через ; идет указание модуля файла
    	if($realname) {
        	$tpl_source = file_get_contents($realname);
        	//добавляем инициализацию объекта виджета
        	return true;
    	} else return false;
	}

	/**
	 *
	 * Время последней модификации шаблона
	 * @param $tpl_name
	 * @param $tpl_timestamp
	 * @param $smarty
	 */
	function timestamp($tpl_name, &$tpl_timestamp, $smarty) {
   		//определяем реальное имя файла
    	$realname = $this->map_name($tpl_name);
    	if($realname) {
        	$stat = stat($realname);
        	$tpl_timestamp = $stat['mtime'];
    	} else return false;
	}

	function secure($tpl_name, &$smarty) {
		return true;
	}

	function trusted($tpl_name, &$smarty) {
    	return true;
    }

    /**
     * Регистрация объекта как виджета
     * @param Smarty &$smarty - объект типа Smarty;
     */

 	function register(&$smarty) {
    	if(is_object($smarty)) {
    		//регистрируем объект как шаблон smarty
    		if(isset($smarty->register)) {
    			//echo "go";
    			$smarty->register->resource('dwidget', array(&$this,'source','timestamp','secure','trusted'));
    		} else {
    			$smarty->registerResource('dwidget', array(&$this,'source','timestamp','secure','trusted'));
    		}
    	} else trigger_error('Wrong object type for dWidget register',E_USER_ERROR);
    }
}
?>