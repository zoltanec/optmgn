<?php
//обработка запросов поступивших от пользователя
class D_Core_Request {
	const NO_DATA = 'NO_DATA_RECIEVED_FOR_PARSING';
	public $module = 'index';
	public $action = '';
	public $uri = '';
	public $_req = array();
	public $current = '';
	public $_POST = array();
	protected $is_robot = NULL;

	private $request_id = '';

	function isAjax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']);
	}
	/**
	 * Конструктор класса обработчика входящих данных запроса
	 * @param int $offset - смещение переменных в обработке запроса
	 */
	function __construct() {
		$this->request_id = md5(print_r($_SERVER,1));


		$this->_POST = &$_POST;

		$this->uri = $this->raw_uri = (isset($_REQUEST['uri'])) ? $_REQUEST['uri'] : '';

		if(is_array(D::$config->{'sys.core.url_rewrites'})) {
			if(isset(D::$config->{'sys.core.url_rewrites'}[$this->uri])) {
				$this->raw_uri = $this->uri;
				$this->uri = D::$config->{'sys.core.url_rewrites'}[$this->uri];
			}
		}

		if(!empty($this->uri)) {
			$offset = D::$config->request_offset;
			//текущий запрос
			$this->current_url = D::$web."/".$this->uri;
			//разбиваем строку на массив
			//echo $_REQUEST['uri'];exit;

			$raw_req = explode("/", (substr($this->uri,0,1) == '/' ? $this->uri : "/".$this->uri));
		
			//обрабатываем наши переменные удаляя из них лишние символы и занося попутно в массив REQUEST
			foreach($raw_req AS $v_key=>$v_value) {
				//проверяем что у нас не пустое значение
				if(empty($v_value)) {
					unset($raw_req[$v_key]);
				}
			}
			//проверяем какая схема адресации используется, новая или старая
			if(isset($raw_req[$offset + 1]) && in_array($raw_req[$offset+1],D::$config->languages) ) {
				$this->lang = $raw_req[$offset + 1];
				//смещение при использовании старой схемы
				$offset++;
			}
			if(isset($raw_req[$offset+1]) AND !empty($raw_req[$offset+1])) {
				$this->module = preg_replace('/[^a-zA-Z0-9\-_\-\.]/','',$raw_req[$offset+1]);
			}
			if(empty($this->module)) { $this->module = D::$config->default_module; }
			if(isset($raw_req[$offset+2]) AND !empty($raw_req[$offset+2])) {
				$this->action = preg_replace('/[^a-zA-Z0-9\-\_\-\.]/','',$raw_req[$offset+2]);
			}
			for($i=3+$offset, $par_num=1; $i<=sizeof($raw_req); $i=$i+1, $par_num++) {
				if(isset($raw_req[$i])) {
					if(($sep_pos = strpos($raw_req[$i],'_')) >= 1) {
						$var_name = substr($raw_req[$i],0,$sep_pos);
						$value = substr($raw_req[$i],$sep_pos + 1);
						$this->_req[$var_name] = $value;
					}
					$this->_req['param'.$par_num] = $raw_req[$i];
				}
			}
			//если пользователь загрузил файлы
			if(sizeof($_FILES) > 0 ){
				$this->uploaded = new D_Core_UploadedFiles();
			}
		} else {
			$this->module = D::$config->default_module;
		}
		//обрабатываем переменные полученные не через ЧПУ
		if(get_magic_quotes_gpc()) {
			foreach($_REQUEST AS $p_key=>$p_value) {
				$this->_req[$p_key] = $p_value;
			}
		} else {
			array_walk_recursive($_REQUEST, function(&$item, $key) {
				$item = addslashes($item);
			});
			foreach($_REQUEST AS $p_key=>$p_value) {
				$this->_req[$p_key] = $p_value;
			}
		}
		if(empty($this->lang)) {
			if(D::$config->multilang) {
				if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
					$langs = D::$config->languages;
					$user_langs = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);

					// в приоритете первый язык пользователя ru-RU, en_EN (приоретет у ru_RU)

					foreach ( $user_langs as $lang_part) {

						foreach($langs AS $lang) {

							if(strpos($lang_part, $lang) === false) {
								continue;
							}
							$this->lang = $lang;
							break;
						}
						if (!empty($this->lang) ) break;
					}
				}
			}
			$this->lang = (empty($this->lang)) ? D::$config->default_language : $this->lang;
		}
	}

	/**
	 * Uniq request ID
	 */
	function getRequestId() {
		return $this->request_id;
	}

	/**
	 * Get full request dump
	 */
	function getDump() {
		$data = "";
		foreach($_SERVER AS $option => $value) {
			$data .= "{$option} : {$value} \n";
		}
		$data.= "\n\n".str_repeat("=", 20)."\nPOST DUMP: \n\n".print_r($_POST,true);
		$data.= "\n\n".str_repeat("=", 20)."\nCOOKIE DUMP: \n\n".print_r($_COOKIE,true);
		if(!empty($_FILES)) {
			$data.= "\n\n".str_repeat("=", 20)."\nFILES DUMP: \n\n".print_r($_FILES,true);
		}
		if(isset($_SESSION)) {
			$data.= "\n\n".str_repeat("=", 20)."\nSESSION DUMP: \n\n".print_r($_SESSION,true);
		}
		return $data;
	}


	/**
	 * Get client IP-address
	 */
	function getIP() {
		return $_SERVER['REMOTE_ADDR'];
	}


	function getReferer() {
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	}

	/**
	 * Get browser information
	 */
	function getBrowser() {
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}

	function isRobot() {
		if($this->is_robot != NULL) return $this->is_robot;

		$agent = $this->getBrowser();

		if(empty($agent)) {
			$this->is_robot = false;
			return false;
		}

		$robots = ['YandexBot', 'YandexImages','YandexDirect', 'YandexNews', 'Googlebot', 'MediaPartners-Google', 'Yahoo! Slurp', 'msnbot'];
		foreach($robots AS $robot) {
			if( strpos($agent, $robot) === false) {
				continue;
			}
			$this->is_robot = true;
			return true;
		}
	}


	// возвращает класс браузера
	function getBrowserClass() {
		$browsers = array('opera' => 'Opera', 'chrome' => 'Chrome', 'firefox' => 'Firefox', 'ie' => 'MSIE', 'ipad' => 'iPad', 'iphone' => 'iPhone');
		foreach($browsers AS $class => $search) {
			if(strpos($_SERVER['HTTP_USER_AGENT'], $search) === false) {
				continue;
			} else {
				return $class;
			}
		}
		return 'default';
	}

	/**
	 *
	 *
	 * @param unknown_type $method
	 * @param unknown_type $arv
	 */
	function __call($method_name, $argv) {
		if(!isset($argv[0])) {
			return false;
		}
		$varname = $argv[0];

		if(isset($this->_req[$varname])) {

			//значение переменной
			$value = $this->_req[$varname];
			$argv[0] = $value;


			//если нам необходимо получить доступ к массиву
			if(substr($method_name, strlen($method_name) - 5) == 'Array') {
				$method_name = substr($method_name, 0, strlen($method_name) - 5);
				if(method_exists($this,'__eval_'.$method_name)) {
					$validator = function(&$item, $key) use ($method_name) {
						$item = call_user_func_array(array(D::$req, '__eval_'.$method_name), array($item));
					};
					array_walk_recursive($value, $validator);
					return $value;
				}
			}

			if(method_exists($this, '__eval_'.$method_name)) {
				//проверяем вообще есть ли такая переменная
					return call_user_func_array(array($this, '__eval_'.$method_name), $argv);
			//похоже переменная даже не задана,тогда определяем ее значение по умолчанию.
			} else {
				if(method_exists($this, '__default_'.$method_name)) {
					return call_user_func_array(array($this,'__default_'.$method_name), $argv);
				} else {
					return NULL;
				}
			}
		} else {
			if(method_exists($this, '__default_'.$method_name)) {
				return call_user_func_array(array($this,'__default_'.$method_name), $argv);
			} else {
				return NULL;
			}
		}
	}

	/**
	 * Функция проверки установлена ли переменная
	 */

	public function __eval_isset() {

		return true;
	}
	protected function __default_isset() {
		return false;
	}

	/**
	 * Текстовый идентификатор
	 * @param string $value - значение переменной
	 */
	public function __eval_textID($value = '' ) {
		return trim(preg_replace('/[^a-zA-Z0-9\-\.\_\+=]/','_', $value));
	}
	protected function __default_textID() {
		return '';
	}

	/**
	 * Номер страницы
	 */
	public function __eval_page($value) {
   		if(in_array($value, array('last','first'))) {
			return $value;
		} else {
			$page = intval($value);
			return ($page < 1) ? 1 : $page;
	   	}
	}
	protected function __default_page() {
		return 'first';
	}

	/**
	 * Целочисленное значение
	 */
	public function __eval_int($value) {
		return intval($value);
	}
	protected function __default_int() {
		return 0;
	}

	/**
	 * Идентификатор объекта в int, не нулевой
	 */
	public function __eval_intID($value) {
		$value = intval($value);
		return ($value > 0 ) ? $value : 1;
	}
	protected function __default_intID() {
		return 1;
	}

	/**
	 * Чистые текст без тегов и прочего хлама
	 */
	public function __eval_clearText($value) {
		return preg_replace('/[<>\[\]]/','',$value);
	}
	protected function __default_clearText() {
		return '';
	}


	/**
	 * Возвращает текстовую строку
	 *
	 * @param string $name - имя текстовой переменной во входящем потоке
	 * @param string $default - значение по умолчанию. если переменная не указана ли пустая,то используется это значение
	 */
	public function __eval_textLine($value) {
		return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
	}

	protected function __default_textLine() {
		return '';
	}

	/**
	 * URL адреса
	 */
	public function __eval_url($value) {
		return preg_replace("/[^a-zA-Z0-9\-\_\.\:\/\=\?]/",'',$value);
	}
	protected function __default_url($value) {
		return '';
	}

	/**
	 * Текст в формате bbCode
	 */
	public function __eval_bbText($value) {
		return htmlspecialchars(trim($value), ENT_COMPAT, 'UTF-8');
	}
	protected function __default_bbText($value) {
		return '';
	}


	/**
	 * Возвращаем текст в формате HTML
	 * @param string $name - имя переменной;
	 */
	public function __eval_html($value) {
		return $value;
	}
	protected function __default_html() {
		return '';
	}

	/**
	 * Булевые переменные
	 */
	public function __eval_bool($value) {
		if($value == 'true' || $value == '1' || $value == 'on') {
			return true;
		} else {
			return false;
		}
	}
	protected function __default_bool() {
		return false;
	}

	/**
	 * Проверяем существование определенной переменной в потоке
	 */
	public function __eval_flag($value) {
		return true;
	}
	protected function __default_flag() {
		return false;
	}

	/**
	 * Сырые данные
	 */
	public function __eval_raw($value) {
		return stripcslashes($value);
	}
	protected function __default_raw() {
		return '';
	}

	/**
	 * Переменные вещественного типа
	 *
	 */
	public function __eval_float($value) {
		return floatval($value);
	}
	protected function __default_float() {
		return 0.0;
	}


	/**
	 *
	 * Выбор значения из массива возможных значение
	 * @param string $name имя переменной значение которой необходимо получить;
	 * @param array $variants возможные значения переменной;
	 */
	public function __eval_select($value,$variants) {
		//проверяем указано ли аще
		 if(in_array($value,$variants)) {
		 	//возвращаем результат
			return $value;
		 } else {
			return $variants[0];
		 }
	}
	public function __default_select($name, $variants) {
		return $variants[0];
	}


	/**
	 * Получаем изображение переданное в запросе
	 * @param string $name - имя файла изображения
	 */
	function image($name) {
		//проверяем передано ли нам это изображение вообще
		if(isset($this->uploaded->files[$name]) AND is_object($this->uploaded->files[$name])) {
			//создаем объект изображения
			$imagefile = new D_Files_Image($this->uploaded->files[$name]);
	 		return $imagefile;
		} else return false;
	}

	/**
	 * Получаем E-Mail пользователя из запроса
	 * @param string $name - имя переменной в которой хранится мыло
	 * @param bool $validate - проводить полную валидацию, включая поиск MX записей для домена и определения работоспособности домена
	 */
	public function __eval_email($value) {
		return preg_replace('/[^a-zA-Z0-9\-\_\.@]/','a',$value);
	}
	protected function __default_email() {
		return '';
	}

	/**
	 * Дата
	 *  ...
	 * @param $name
	 */
	function date($name) {
		if(isset($this->_req[$name])) {
			return $this->_req[$name];
		} else return '1970-01-01';
	}

	function referer() {
		return htmlspecialchars($_SERVER["HTTP_REFERER"],ENT_QUOTES);
	}

	/**
	 *
	 */
	function datetime($name) {
		$day = $this->select($name.'_day', range(1,31));
		$month = $this->select($name.'_month', range(1,12));
		$year = $this->int($name.'_year');
		$hour = $this->select($name.'_hour', range(0,24));
		$min  = $this->select($name.'_min',  range(0,59));

		$time = new D_Core_Time();
		$time->mday($day)->month($month)->year($year)->hour($hour)->min($min);
		return $time;
	}


	//функция выполняем доступ к переменным запроса как в свойствам
	function __get($name) {
		if(isset($this->_req[$name])) {
			return $this->_req[$name];
		} else return NULL;
	}

	/**
	 * Выполняем маппинг переменных из запроса пользователя на свойства объекта. Формат карты проверок:
	 * array( 'переменная' => array('type' => 'тип_переменной',
	 * 'params' => array('массив дополнительных параметров передаваемых проверяющей функции'),
	 * 'property_name'=>'имясвойства_если_оно_отличается_от_имени_переменной'));
	 *
	 * @param mixed $object объект для которого задаются свойства;
	 * @param array $map карта проверок;
	 */
	function map(&$object, $map) {
		//проверяем что нам передан объект
		if(is_object($object)) {
			//обрабатываем переменные
			foreach($map AS $varname => $variable) {
				if(is_array($variable)) {
					//обрабатываем переменные
					if(method_exists($this, $variable['type'])) {
						$params_array = array($varname);
						//если функции требуются дополнительные параметры ( например варианты выбора ) то передаем их
						if(isset($variable['params'])) {
							$params_array = array_merge($params_array,$variable['params']);
						}
						$property_name = (isset($variable['property_name'])) ? $variable['property_name'] : $varname;
						//загружаем свойство
						$object->{$property_name} = call_user_func_array(array(&$this,$variable['type']),$params_array);
					}
				//если формат карты простой
				} else {
					if(method_exists($this,'__eval_'.$variable)) {
						$object->{$varname} = $this->__call($variable, array($varname));
					} else {
						trigger_error("No such variable type {$variable}.",E_USER_NOTICE);
					}
				}
			}
		} else {
			trigger_error('$object is not object variable.',E_USER_NOTICE);
		}
	}

	/**
	 * Check user for mobile browsing
	 */
	public function isMobile() {
		if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']))
			return false;

		$user_agent = $_SERVER['HTTP_USER_AGENT'];


		if (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|'.
			'wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|'.
			'lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|'.
			'mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|'.
			'm881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|'.
			'r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|'.
			'i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|'.
			'htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|'.
			'sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|'.
			'p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|'.
			'_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|'.
			's800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|'.
			'd736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |'.
			'sonyericsson|samsung|240x|x320vx10|nokia|sony cmd|motorola|'.
			'up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|'.
			'pocket|kindle|mobile|psp|treo|iphone)/i', $user_agent)) {
			return true;
		}

		if (in_array(substr($user_agent,0,4),
		Array("1207", "3gso", "4thp", "501i", "502i", "503i", "504i", "505i", "506i",
			  "6310", "6590", "770s", "802s", "a wa", "abac", "acer", "acoo", "acs-",
			  "aiko", "airn", "alav", "alca", "alco", "amoi", "anex", "anny", "anyw",
			  "aptu", "arch", "argo", "aste", "asus", "attw", "au-m", "audi", "aur ",
			  "aus ", "avan", "beck", "bell", "benq", "bilb", "bird", "blac", "blaz",
			  "brew", "brvw", "bumb", "bw-n", "bw-u", "c55/", "capi", "ccwa", "cdm-",
			  "cell", "chtm", "cldc", "cmd-", "cond", "craw", "dait", "dall", "dang",
			  "dbte", "dc-s", "devi", "dica", "dmob", "doco", "dopo", "ds-d", "ds12",
			  "el49", "elai", "eml2", "emul", "eric", "erk0", "esl8", "ez40", "ez60",
			  "ez70", "ezos", "ezwa", "ezze", "fake", "fetc", "fly-", "fly_", "g-mo",
			  "g1 u", "g560", "gene", "gf-5", "go.w", "good", "grad", "grun", "haie",
			  "hcit", "hd-m", "hd-p", "hd-t", "hei-", "hiba", "hipt", "hita", "hp i",
			  "hpip", "hs-c", "htc ", "htc-", "htc_", "htca", "htcg", "htcp", "htcs",
			  "htct", "http", "huaw", "hutc", "i-20", "i-go", "i-ma", "i230", "iac",
			  "iac-", "iac/", "ibro", "idea", "ig01", "ikom", "im1k", "inno", "ipaq",
			  "iris", "jata", "java", "jbro", "jemu", "jigs", "kddi", "keji", "kgt",
			  "kgt/", "klon", "kpt ", "kwc-", "kyoc", "kyok", "leno", "lexi", "lg g",
			  "lg-a", "lg-b", "lg-c", "lg-d", "lg-f", "lg-g", "lg-k", "lg-l", "lg-m",
			  "lg-o", "lg-p", "lg-s", "lg-t", "lg-u", "lg-w", "lg/k", "lg/l", "lg/u",
			  "lg50", "lg54", "lge-", "lge/", "libw", "lynx", "m-cr", "m1-w", "m3ga",
			  "m50/", "mate", "maui", "maxo", "mc01", "mc21", "mcca", "medi", "merc",
			  "meri", "midp", "mio8", "mioa", "mits", "mmef", "mo01", "mo02", "mobi",
			  "mode", "modo", "mot ", "mot-", "moto", "motv", "mozz", "mt50", "mtp1",
			  "mtv ", "mwbp", "mywa", "n100", "n101", "n102", "n202", "n203", "n300",
			  "n302", "n500", "n502", "n505", "n700", "n701", "n710", "nec-", "nem-",
			  "neon", "netf", "newg", "newt", "nok6", "noki", "nzph", "o2 x", "o2-x",
			  "o2im", "opti", "opwv", "oran", "owg1", "p800", "palm", "pana", "pand",
			  "pant", "pdxg", "pg-1", "pg-2", "pg-3", "pg-6", "pg-8", "pg-c", "pg13",
			  "phil", "pire", "play", "pluc", "pn-2", "pock", "port", "pose", "prox",
			  "psio", "pt-g", "qa-a", "qc-2", "qc-3", "qc-5", "qc-7", "qc07", "qc12",
			  "qc21", "qc32", "qc60", "qci-", "qtek", "qwap", "r380", "r600", "raks",
			  "rim9", "rove", "rozo", "s55/", "sage", "sama", "samm", "sams", "sany",
			  "sava", "sc01", "sch-", "scoo", "scp-", "sdk/", "se47", "sec-", "sec0",
			  "sec1", "semc", "send", "seri", "sgh-", "shar", "sie-", "siem", "sk-0",
			  "sl45", "slid", "smal", "smar", "smb3", "smit", "smt5", "soft", "sony",
			  "sp01", "sph-", "spv ", "spv-", "sy01", "symb", "t-mo", "t218", "t250",
			  "t600", "t610", "t618", "tagt", "talk", "tcl-", "tdg-", "teli", "telm",
			  "tim-", "topl", "tosh", "treo", "ts70", "tsm-", "tsm3", "tsm5", "tx-9",
			  "up.b", "upg1", "upsi", "utst", "v400", "v750", "veri", "virg", "vite",
			  "vk-v", "vk40", "vk50", "vk52", "vk53", "vm40", "voda", "vulc", "vx52",
			  "vx53", "vx60", "vx61", "vx70", "vx80", "vx81", "vx83", "vx85", "vx98",
			  "w3c ", "w3c-", "wap-", "wapa", "wapi", "wapj", "wapm", "wapp", "wapr",
			  "waps", "wapt", "wapu", "wapv", "wapy", "webc", "whit", "wig ", "winc",
			  "winw", "wmlb", "wonu", "x700", "xda-", "xda2", "xdag", "yas-", "your",
			  "zeto", "zte-"))) {
			  return true;
  		}
		return false;
	}

	/**
	 * Готовим и делаем запрос с GET параметрами
	 */
	static function FormGET($url, $variables) {
		$parsed = array();
		foreach($variables AS $name => $value) {
			$parsed[] = $name.'='.urlencode($value);
		}
		return $url.'?'.implode('&', $parsed);
	}

}
?>
