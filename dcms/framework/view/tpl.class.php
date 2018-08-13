<?php
define('SMARTY_SPL_AUTOLOAD',1);
class D_View_Tpl extends Smarty
{
	//заголовок отрендеренной страницы
	public $title = '';
	//описание страницы
	public $description = '';

	public $main_template="theme.tpl";
	public $mainResource = false;
    public $tpl_path = '';
    //пути к виджетам
    public $widgets_path = array();
    //источники шаблонов smarty
    public $registration_list = array();
    //база редиректа. по какому пути перенаправлять когда указано ~ в начале
    public $redirect_base = '';
    public $renderingStarted = false;
    // is rendering started or not
    public $rendering_started  = false;
    // is rendering finished
    public $rendering_finished = false;


    public $renderResource = false;
    // rendering mode, 0 mean old rendering style
    // bread crumbs
    private $bread_crumbs = array();

    private $initialized = false;
	// отображать чистый шаблон без подключения к теме
	private $clear_rendering = false;
	private $me = array();
	// рабочий каталог шаблонизатора
	private $work_path = '';
    protected $tpl_config = array();
    // list of all CSS file in view
    protected $css = array();
    // list of all JavaScript file in view
    protected $javascripts = array();

    public $theme = array();

    /**
     * Breadcrumbs options
     */
    private $bc_reverse = false;
    private $bc_reverse_pool = array();
    private $bc_pool = array();
    private $content_type = "text/html; charset=UTF-8";


    /**
     *  Шаблонизатор Smarty
     * @param string $work - каталог где будут расположены временные файлы шаблонизатора
     */
     function __construct() {
        $this->work_path = D::$config->templates_work_dir;

        $this->me = array('www' => &D::$web, 'path' => &D::$web_module, 'core' => D::$web.'/core', 'content' => &D::$content);
     }

    //инициализируем класс объектом smarty
    function init() {
    	if($this->initialized) {
    		return true;
    	}
    	$this->me['my_content'] = D::$config->{'sys.content.path'}."/".D::$module;

        //инициализируем родительским классом
        parent::__construct();
        $this->caching = false;

       	$this->assignByRef('t', $GLOBALS['T']);

        foreach(array_keys($GLOBALS['T']) AS $key) {
        	$this->assignByRef($key, $GLOBALS['T'][$key]);
        }

        $this->assign('meta', array('title' => $this->title, 'description' => $this->description));
        // for localization we need
        $this->compile_dir  = $this->work_path."/templates_c/".D::theme()."/";
        $this->config_dir   = $this->work_path."/configs/";
        $this->cache_dir    = $this->work_path."/cache/";
        $this->left_delimiter = '<{';
        $this->right_delimiter = '}>';
        if(!empty($this->tpl_path)) {
            $this->template_dir = $this->tpl_path;
        } else $this->template_dir = D::$path."/modules/".D::$module."/templates/";
        //плагины
        $this->plugins_dir[] = D::$framework."/smarty_plugins/";
        foreach($this->registration_list AS &$object) {
        	$object->register($this);
        }
        $this->assignByRef('config', D::$config);
        $this->initialized = true;
    }

    function setContentType($type) {
    	$this->content_type = $type;
    }

    function InitTemplateRender() {
    	if($this->renderings_started) {
    		return true;
    	}

    	if(D::$req->isAjax()) {
    		$this->setClearRendering();
    	}
    	//echo "NO";
     	header("Content-type: ".$this->content_type);

    	$this->init();
    	$this->rendering_started = true;
        $this->assign('req',D::$req);
        //делаем видимым параметры конфигурации внутри шаблона
        $this->assign('config',D::$config);
        $this->assign('user',D::$user);
        $this->assign('me', $this->me );
        $this->assignByRef('db',D::$db);
        $this->assignByRef('cache', D::$cache);
        $this->assignByRef('tpl', $this);
        $this->theme = array('css'=> D::$config->themes_path.'/'.D::theme().'/css',
                         'images' => D::$config->themes_path.'/'.D::theme().'/images',
        			     'mimages'=> D::$config->themes_path.'/'.D::theme().'/images/'.D::$module);

        /**
		 * создаем переменные путей для шаблонов к css и images
		 * по модульной схеме расположения:
		 * /themes/default/pages/ - $theme.pages.css
         * /themes/default/pages/images - $theme.pages.images
        **/

        $modules = D::getSearchModules();

        foreach ( $modules as $module ) {

        	$this->theme[$module] = array(
        		'css' => D::$config->themes_path.'/'.D::theme().'/'.$module,
        		'images' => D::$config->themes_path.'/'.D::theme().'/'.$module.'/images'
        	);
        }

        $this->assignByRef('theme',$this->theme);

    }

     //отображение информации на экране
    function show($template) {
    	if($this->isRenderingFinished()) { return true; }


    	$this->InitTemplateRender();
    	// надо ли рендерить главный шаблон
    	if($this->clear_rendering) {
    		parent::display($template);
    	} else {
    		$this->assignByRef('moduletemplate',$template);
    		//var_dump($this->get_template_vars($moduletemplate));exit;
    		if($this->mainResource) {
	    		parent::display($this->mainResource);

    		} else {
	        	parent::display('dit:'.D::$path."/themes/".D::theme()."/".$this->main_template);
    		}
    	}
    	$this->setRenderingFinish();
    }

    function fetch_output($template) {
    	if($this->isRenderingFinished()) {
    		return true;
    	}
    	$this->InitTemplateRender();

    	return parent::fetch($template);
    }

    function show500($template) {
    	header("HTTP/1.0 500 Internal Server Error");
    	$this->show($template);
    }

    /**
     * Add new bread crumb element
     *
     * @param string $moduletemplate
     */
    function addBC($link = '', $name = '') {
    	$link =  array('link' => $this->getRedirectPath($link), 'name' => $name);
    	if($this->bc_reverse) {
    		$this->bc_reverse_pool[] = $link;
    	} else {
    		$this->bc_pool[] = $link;
    	}
    }

    /**
     * Start adding breadcrumbs in reverse mode, when last added links must be first
     */
    function startBcReverse() {
    	$this->bc_reverse = true;
    }

    /**
     * Stop reverse and fill bread crumbs
     */
    function stopBcReverse() {
    	$this->bc_reverse = false;
    	if(sizeof($this->bc_reverse_pool) > 0 ) {
    		$this->bc_pool = array_merge($this->bc_pool, array_reverse($this->bc_reverse_pool));
    		$this->bc_reverse_pool = array();
    	}
    }


    /**
     * Get site bread crumbs
     *
     * @return Array $bread_crumbs - return site bread crumbs;
     */
    function getBreadCrumbs() {
    	return $this->bc_pool;
    }


    function printable($moduletemplate) {
    	$this->main_template = 'print.tpl';
    	$this->show($moduletemplate);
    }

    function RenderTpl($template) {
    	$this->InitTemplateRender();
    	parent::display($template);
    	$this->setRenderingFinish();
    	D::sysExit();
    }

    function set($name, &$value) {
    	$this->assignByRef($name, $value);
    }

    // при рендеринге не будет использоваться шаблон темы
    public function setClearRendering() {
    	$this->clear_rendering= true;
    }
    // заканчиваем рендеринг
    protected function setRenderingFinish() {
    	$this->rendering_finished = true;
    }
    protected function isRenderingFinished() {
    	return $this->rendering_finished;
    }
    /**
     * Перенаправление пользователя на другую страницу
     *  ...
     * @param string $RedirectPath - путь куда перенаправляем пользователя, можно использовать ~ чтобы указать путь относительно текущей базы редиректов ( из $redirect_base );
     */
    function Redirect($RedirectPath = '') {
    	header("Location: ".$this->getRedirectPath($RedirectPath));
    	$this->setRenderingFinish();
    	D::sysExit();
    }

    /**
     * Permanent redirect на новый адрес
     */
    function RedirectPermanently($RedirectPath) {
    	header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$this->getRedirectPath($RedirectPath));
		$this->setRenderingFinish();
		D::sysExit();
	}

    /**
     * Вычисление пути куда необходимо выполнить редирект
     * @param string $RedirectPath - куда выполняется редирект
     */
    function getRedirectPath($RedirectPath = '') {
    	if(!empty($RedirectPath)) {
    		 if($RedirectPath[0] =='/') {
            	$resultPath = D::$web.$RedirectPath;
        	} elseif($RedirectPath[0] == '~') {
            	//меняем содержимое
            	$resultPath = D::$web.str_replace('~',$this->redirect_base,$RedirectPath);
        	} else {
        		$resultPath = $RedirectPath;
        	}
    	} else {
    		$resultPath = '/';
    	}
    	return $resultPath;
    }

    /**
     * Print raw text
     *
     * @param unknown_type $text
     */
    function PrintText($text) {
		header("Content-type: {$this->content_type}; charset=UTF-8");
    	echo $text;
    	D::SysExit();
    }

    function PrintJSON($variable) {
    	if(D::$req->isAjax()) {
    		header("Content-type: application/json; charse=UTF-8");
    	}
    	echo json_encode($variable);
    	D::SysExit();
    }

    /**
     * В зависимости от метода запроса мы можем либо ответить
     * @param string $url -адрес куда следуюет перенаправить при запросе без AJAX
     * @param array $array - массив который будет преобразован в JSON если запрос выполняется через AJAX
     */
    function RedirectOrJSON($url, $array) {
    	if(D::$req->isAjax()) {
    		$this->PrintJSON($array);
    	} else {
    		$this->Redirect($url);
    	}
    	D::sysExit();
    }

    /**
     * В зависимости от метода запроса отображаем текст или перенаправляем пользователя
     */
    function RedirectOrText($url, $text) {
    	if(D::$req->isAjax()) {
    		$this->PrintText($text);
    	} else {
    		$this->Redirect($url);
    	}
    	D::sysExit();
    }

    /**
     * Отображение шаблонов в формате XML
     * @param string $template - имя файла шаблона.
     */
    function xml($template) {
    	//инициализация Smarty
    	$this->init();
    	$this->InitTemplateRender();
    	header("Content-type: text/xml; charset=UTF-8");
    	parent::display($template);
    	D::SysExit();
    }



    /**
     * Удаляем пробелы и прочие жуткие вещи из исхожного кода сайта
     */
    function strip($source, $smarty) {
    	//ищем сообщения языка
   		$from = array('/>(\s+)</','/>(\s+)#([A-Z0-9\_]+)#/','/{\/([a-z0-9]+)}(\s+)/','/\s+<\/([a-z0-9]+)>/');
    	$to = array('><','>#\2#','{/\1}','</\1>');
    	$source = preg_replace($from,$to,$source);
    	return $source;
    }

    function memory_usage() {
    	return round(memory_get_usage()/1024).'kB';
    }

	/**
     * Add new JavaScript to site header
     *
     * @param string $file - file from javascripts path, for example
     */
    function addJavaScript($file) {
    	if($this->rendering_started) {
    		echo "<script type=\"text/javascript\" src=\"".D::$config->jscripts_path."/".$file."\"></script>\n";
    	}
    	if(!in_array($file, $this->javascripts)) { $this->javascripts[] = $file;}
    }

    /**
     * Render standart headers for CMS
     */
    function getJsHeaders($mode = 'simple') {
    	$result = "";
    	$js_list = array('d','ui');
    	switch (D::$config->jquery_source) {
    		case "google": $jquery_link = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";break;
    		case "jquery": $jquery_link = "http://code.jquery.com/jquery-1.7.2.min.js"; break;
    		case "yandex": $jquery_link = "https://yandex.st/jquery/1.8.2/jquery.min.js"; break;
    		case "local" : $jquery_link = D::$config->jscripts_path."/jquery.js"; break;
    		case "custom": $jquery_link = D::$config->jquery_path; break;
    	}
    	$result.=  "<script type=\"text/javascript\" src=\"{$jquery_link}\"></script>\n";
    	foreach($js_list AS $jscript ) {
    		$result.=  "<script type=\"text/javascript\" src=\"".D::$config->jscripts_path."/".$jscript.".js\"></script>\n";
    	}
    	if($mode == 'full') {
    		$result .= '<script type="text/javascript">';
    		$result .= 'var D = new D({	www: \''.$this->me['www'].'\',
    		theme_images: \''.$this->theme['images'].'\',
    		content: \''.$this->me['content'].'\'});
</script>';
    	}
    	return $result;
    }

    /**
     * Add new CSS to site header
     *
     * @param string $file - file from theme.css path, for example
     */
    function addCss($file) {
    	if($this->rendering_started) {
    		echo "<link href=\"".$this->theme['css']."/{$file}\" rel=\"stylesheet\" type=\"text/css\" />\n";
    	}
    	if(!in_array($file, $this->css)) { $this->css[] = $file;}
    }

	/**
	 * Show all loaded CSS
	 *
	 * @return string $headers - list of HTML headers
	 */
    function getCssHeaders() {
		$headers = "";
		foreach($this->css AS $file) {
			$headers.="<link href=\"".$this->theme['css']."/{$file}\" rel=\"stylesheet\" type=\"text/css\" />\n";
		}
		return $headers;
    }

    /**
     * Get list of available themes
     */
    function getThemesList() {
    	$dirs = D_Core_Filesystem::getDirListing(D::$config->themes_dir);
    	$themes = array();
    	foreach($dirs AS $dir) {
    		$themes[] = $dir['name'];
    	}
    	return $themes;
    }

    /**
     * Clear compiled templates cache
     */
    function clearCache() {
	    // now let's remove cache for language files
    	foreach($this->getThemesList() AS $theme) {
    		if(D::$config->multilang) {
	    		foreach(D::$config->languages AS $lang) {
    				D_Core_Filesystem::rmdir(D::$config->work_dir."/smarty/".$lang."/templates_c/".$theme);
    			}
    		} else {
    			D_Core_Filesystem::rmdir(D::$config->work_dir."/smarty/templates_c/".$theme);
    		}
    	}
    	return true;
    }
}