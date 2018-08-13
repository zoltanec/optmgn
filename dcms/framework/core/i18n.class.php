<?php
class D_Core_I18n {
	private $lang = 'en';
	//флаг что необходимо создавать сообщения в базе для тех полей которые не заданы
	private $createDbMessages = false;
	/**
	 * Конструктор класса локализации
	 * @param string $lang - язык на который будет выполнятся перевод
	 */
	function __construct($lang = 'en') {
		$this->lang = $lang;
	}

	/**
	 * Перевод сообщения в транслит
	 * @param string $phrase - фраза для преобразования в транслит
	 */
	static function translit($phrase, $reverse = false) {
		//список русских букв
		$letters_in=array(' э','шь','а','б','в','г','д','е','ё','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ъ','ы','э','ж','ц','ч','ш','щ','ю','я','ь');
		//соответсвующие замены в английской раскладке
		$letters_out=array(' e','sh','a','b','v','g','d','e','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','\'','i','ei','zh','ts','ch','sh','shch','yu','ya','\'');
		//эквиваленты замены в верхнем регистре
		$letters_big_out=array_map("strtoupper",$letters_out);
		foreach($letters_in AS $key=>$letter) {
			//преобразуем юникод букву в верхний регистр
			$letters_big_in[]=mb_strtoupper($letter,"UTF-8");
		}
        if($reverse){
			$letters_rus = $letters_in;
			$letters_in = $letters_out;
			$letters_out = $letters_rus;
			unset($letters_rus);
		}
		$phrase=str_replace($letters_in,$letters_out,$phrase);
		$phrase=str_replace($letters_big_in,$letters_big_out,$phrase);
		return $phrase;
	}

	/**
	 * Перевод сообщения по коду на другой язык
	 * @param string $msg_code - код сообщения которое надо перевести
	 * @param string $lang - язык сообщения
	 * @param boolean $cache - кэш
	 * @param boolean $force - запись ненайденых значений для перевода в базу
	 * 						   если параметер установлен в true или false он замещает
	 * 						   значение из конфига "i18n_translate_save".
	 */

	static function translate($mcode, $lang = false, $cache = TRUE,$force = -1) {

		if ( $force == -1 ) {
			$force = (strtolower(D::$config->{'core.i18n.translate_save'}) == 'on' ) ? true : false;
		}
		
		if (!$lang) {
			$lang = D::$i18n->lang;
		}
		$msg_code = strtoupper($mcode);
		$msg_text = D::$db->fetchvar("SELECT msg_text FROM #PX#_core_messages WHERE msg_code = '{$msg_code}' AND lang = '{$lang}' LIMIT 1");
		if(empty($msg_text)) {
			$msg_text = D::$db->fetchvar("SELECT msg_text FROM #PX#_core_messages WHERE msg_code = '{$msg_code}' AND lang = 'en' LIMIT 1");
		}

		if ( $force && empty($msg_text)) {
			D::$db->exec("INSERT INTO #PX#_core_messages VALUES('{$msg_code}','{$lang}','','{$mcode}',0,0,0)");
		}
		return ( empty($msg_text)) ? $mcode : $msg_text;
	}


	function getTranslation($msg_code, $replacements = array()) {
		$result = self::translate(strtoupper($msg_code), $this->lang);
		// if we need to replace some variables in translation than let's do it
		return (sizeof($replacements) > 0 ) ? str_replace(array_keys($replacements), array_values($replacements), $result) : $result;
	}


	/**
	 * Фильтр для обработки шаблонов перед их компиляцией
	 * @param string $source - исходный код шаблона;
	 * @param Smarty $smarty - объект Smarty.
	 */
	function prefilter($source, $smarty) {
		//var_dump($this);exit;
		//ищем сообщения языка
		preg_match_all('/#([A-Z0-9\_]+)#/',$source,$matches );
		$codes = array();
		$msgs = array();
		//проверяем что мы таки нашли чото
		if(sizeof($matches[1])>0) {
			$lng_messages = D::$db->fetchlines_clear("SELECT msg_code, msg_text, html FROM #PX#_core_messages WHERE lang = '{$this->lang}' AND msg_code IN ('".implode("','",$matches[1])."')");
		} else return $source;
		//теперь обрабатываем найденные сообщения
		foreach($matches[1] AS $code) {
			if(isset($lng_messages[$code])) {
				$codes[] = "#$code#";
				//сохраняем сообщение
				$msg = $lng_messages[$code];
		   		$msgs[] = $msg['msg_text'];
			}
		}
		//если необходимо забивать в базу сообщения которые не найдены, то находим список этих сообщений и забиваем
		if($this->createDbMessages) {
			$unsettedCodes = array_diff($matches[1], array_keys($lng_messages));
			//сохраняем переменную для замыкания
			$lang = $this->lang;
			$parseCode = function ($code) use ($lang) {
				return "('{$code}','{$lang}','{$code}')";
			};
			//если найдены коды отсутствующие в базе, то преобразовываем их для SQL выражения
			if(sizeof($unsettedCodes) > 1) {
				$prepairedQuery = array_map($parseCode, $unsettedCodes);
				D::$db->exec("INSERT INTO #PX#_core_messages (msg_code,lang,msg_text) VALUES ".implode(',',$prepairedQuery).' ON DUPLICATE KEY UPDATE upd_time = UNIX_TIMESTAMP()');
			}
		}

		// if we don't have translation in this language we will use
		// default site language.
		if($this->lang != D::$config->default_language) {
			$unsetted_codes = array_diff($matches[1], array_keys($lng_messages));
			foreach($unsetted_codes AS $code) {
				$codes[] = "#$code#";
				$msgs[]  = self::translate($code, D::$config->default_language);
			}
		}
		if( sizeof($codes) > 0 ) {
			 return str_replace($codes,$msgs,$source);
		} else return $source;
	}

	function getJavaScriptMessages() {
		return D::$db->fetchlines("SELECT msg_code, msg_text FROM #PX#_core_messages WHERE lang = '{$this->lang}' AND javascript");
	}

	function templateTranslate($data = array()) {
		if(!empty($data['code'])) {
			return self::translate($data['code'], $this->lang);
		} else {
			return '';
		}
	}

	/**
	 * Регистрируем объект в Smarty
	 * @param Smarty - объект Smarty
	 */
	function register(&$smarty) {
		//регистрируем наш объект как префильтр для smarty
		if(is_object($smarty->register)) {
			$smarty->register->prefilter(array(&$this,'prefilter'));
			$smarty->register->templateFunction('_', array(&$this,'templateTranslate'));
		} else {
			$smarty->registerFilter('pre',array(&$this,'prefilter'));
			$smarty->registerPlugin('function','_', array(&$this,'templateTranslate'));
		}
	}
}