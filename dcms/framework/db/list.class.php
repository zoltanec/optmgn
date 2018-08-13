<?php
//листинги и списки
class D_Db_List extends D_Core_Object implements Countable,Iterator {
    //параметры кэширования страниц объекта
    public $pagecaching = array('full' => 3600, 'unfinished' => 10);
    //настройки по умолчанию
    public $defaults = array('page' => 1, 'perpage' => 50);
    private $_perpage = 0;
    private $caching = true;
    static protected $cacheable = array('total' => 10, 'objects' => 0);
    public $container = 'stdClass';
    private $position = 1;
    public $total_query = '';
    public $fetch_query = '';
    public $_order = 'normal';

    // порядок нумерации в переменной num, all значит что с нуля, а page - для каждой страницы свой
    // порядок, all_top - нумерация начинается сверху
    // all_bottom - нумерация начинается снизу
    // page - нумерация идет сверху, без привязки к общему количеству
    public $num_mode = 'page';
    //количество страниц отображаемых в пейджере
    const PAGER_VISIBLE_PAGES = 5;
    // флаг что данный список необходимо проходить полностью при работе итератора
    private $iterateFull = false;

    // конструктор класса
    function __construct($query = '') {
    	$this->fetch_query = $query;
    }

    //возврат выбранной страницы
    function fetchPage() {
        //проверяем режим сортировки
        $offset = intval(( $this->page - 1 ) * $this->perpage);
        //проверяем если задано внутреннее выражение для получения инфы из базы
        if(empty($this->fetch_query)) {
        	return [];
        }

        //идентификатор для кэширования данного объекта
		$cache_id = md5($this->fetch_query).".page{$this->page}.perpage{$this->perpage}.order{$this->order}";
		if($this->caching && isset(D::$cache->{$cache_id})) {
			return D::$cache->{$cache_id};
		}

		//выполняем запрос к базе данных
        $pagedata = D::$db->fetchobjects($this->fetch_query." LIMIT {$this->perpage} OFFSET {$offset}", $this->container);

        //если найдены хоть какие то результаты
        if(sizeof($pagedata) == 0) {
        	return [];
        }

        if($this->num_mode == 'all') {
        	if($this->order == 'normal') {
            	foreach($pagedata AS &$listElem) {
            		$listElem->num = $listElem->num + ($this->page - 1 ) * $this->perpage;
            	}
            }
		}

		if($this->order == 'reverse') {
			$pagedata = array_reverse($pagedata);
		}

        //проверяем не нужно ли нам кэшировать определенные поля в объектах
        if(method_exists(reset($pagedata), '__precache')) {
        	//обходим все элементы и выполняем функция
          		foreach($pagedata AS &$listElem) {
          			$listElem->__precache();
          		}
        }

        //если страница заполнена полностью то ее можно закэшировать как готовую страницу
        if($this->caching && sizeof($pagedata) == $this->perpage) {
			D::$cache->set($cache_id, $pagedata, $this->pagecaching['full']);
		} else {
			D::$cache->set($cache_id, $pagedata, $this->pagecaching['unfinished']);
		}
		return $pagedata;
    }

    function setCaching($mode) {
    	$this->caching = ($mode) ? true : false;
    }

    function __get_objects() {
    	return $this->fetchPage();
    }

    public function count() {
    	return sizeof($this->objects);
    }

    function __get_total() {
    	if(empty($this->total_query)) {
    		$this->total_query = preg_replace('/\/\*COLS\*\/(.*)\/\*\/COLS\*\//',' COUNT(1) ', $this->fetch_query);
    	}
    	return D::$db->fetchvar($this->total_query);
    }

    //установка минимального значения страниц
    function __get_perpage() {
    	return ($this->_perpage != 0) ? $this->_perpage : $this->defaults['perpage'];
    }
    function __set_perpage($value) {
    	//временная переменная
    	$tmp = intval($value);
    	if($tmp == 0) {
    	   $tmp = $this->defaults['perpage'];
    	}
		//раз мы знаем количество на страницу то можем и количество страниц посчитать
    	$this->_perpage = $tmp;
    }

    //указание режима отображения
    function __set_order($value) {
    	if(in_array($value,array('reverse','normal'))) {
    		$this->_order = $value;
    	} else {
    		$this->_order = 'normal';
    	}
    }

    //получаем порядок
    function __get_order() {
    	if(isset($this->_order)) {
    		return $this->_order;
    	} else {
    		return $this->_order = 'normal';
    	}
    }

    //устанавливаем текущую страницу
    function __set_page($page) {
        //при обратной сортировке в начале будут страницы имеющие больший ID
        if($this->order == 'reverse') {
            //если надо достать первую страницу
            if($page == 'first') {
                //вычисляем номер страницы
                $this->_page = $this->totalpages;
            //если необходимо достать последнюю страницу
            } elseif($page == 'last') {
                $this->_page = 1;
            } else {
            	$this->_page = $page;
            }
        //если у нас порядок от меньшего к большему
        } elseif ($this->order == 'normal') {
            //для первой страницы
            if($page == 'first') {
                $this->_page = 1;
            } elseif ($page == 'last') {
                $this->_page = $this->totalpages;
            } else {
            	$this->_page = $page;
            }
        }
        //приводим идентификатор страницы к типу INT
        $this->_page = abs(intval($this->_page));
        //если страница неправильно указана
        if($this->_page == 0 ) {
        	//если страница некорректная то ставим ее как первую
            $this->_page = $this->firstpage;
        }
    }

    //следующая страница
    function __get_nextpage() {
    	return $this->page+1;
    }
    //предыдущая страница
    function __get_prevpage() {
    	return $this->page-1;
    }

    //получаем текущую страницу
    function __get_page() {
		return ($this->_page > 0) ? $this->_page : 1;
    }

	//высчитываем последнюю страницу
	function __get_lastpage() {
		//возвращаем страницу
		return ($this->order == 'reverse') ? 1 : $this->totalpages;
	}
	//первая страница
	function __get_firstpage() {
		return ($this->order == 'reverse') ? $this->totalpages : 1;
	}

	//высчитываем количество страниц
	function __get_totalpages() {
		return ceil($this->total/$this->perpage);
	}
	function __get_total_pages() {
		return $this->totalpages;
	}

	function __get_end_page() {
		return ($this->order == 'normal') ? $this->totalpages : 1;
	}

	//листалка
    function pager() {
    	if($this->total <= $this->perpage) { return array(1); }
		if($this->totalpages >= 15) {
			if($this->page < 5 or $this->page >= $this->totalpages - 5 ) {
				$pages = array_merge(range(1,5),array('..'),range($this->totalpages-5,$this->totalpages));
			} else {
				$pages = array_merge(range(1,5),array('..'),range($this->page-2,$this->page+2),array('..'),range($this->totalpages-5,$this->totalpages));
			}
		} else {
			//составляем массив всех страниц
			$pages = range(1,$this->totalpages);
		}
		return  array_reverse($pages);
    }

    function simple_pager() {
    	$pager = $this->pager2();
    	//var_dump($pager);exit;
    	if($this->order == 'reverse') {
    		return array_reverse($pager);
    	} else return $pager;
    }

    function pager2() {
    	if($this->totalpages <= self::PAGER_VISIBLE_PAGES ) {
    		return range(1, $this->totalpages);
    	}
    	//количество страниц по бокам от текущей страницы, например если 5 страниц отображаем то слева 2 страницы и справа 2 страницы
    	$sideCount = floor(self::PAGER_VISIBLE_PAGES / 2);
    	if($this->page + $sideCount >= $this->totalpages )  {
    		return range($this->page - $sideCount, $this->totalpages);
    	}
    	if($this->page - $sideCount <= 0) {
			return range(1, $this->page + $sideCount);
    	}
		return range($this->page - $sideCount,$this->page + $sideCount);
    }

    //кэширование объекта
    static public function __fetch($id = '') { }

  //  public function object_id() {
//		return 'dlist-object-random-'.md5($this->fetch_query);
  //  }

    protected function __object_id() {
    	return array(md5($this->fetch_query));
    }

    protected function __save() {
    	return true;
    }


    /**
     * Функции для работы итератора
     */
     function current() {
     	return $this->objects[$this->position];
     }

     function key() {
     	return $this->position;
     }

     function next() {
     	++$this->position;
     }

     function valid() {
     	return isset($this->objects[$this->position]);
     }

     function rewind() {
     	$this->position = 0;
     }
     /**
      * Сброс объекта, будет выполнен повторный запрос к базе данных и тд и тп
      */
     function reset() {
     	$this->untouch(array('objects'));
     }

}
?>