<?php
class dNoSuchObjectException extends D_Core_Exception {
	public $userLevel = false;

	function getInfo() {
		return unserialize($this->getMessage());
	}
}
class dNoFetchMethodException extends D_Core_Exception {
	public $userLevel = false;
}
/**
 * Класс фабрика для создания кэшированных объектов
 *
 */
class D_Core_Factory {
	//размер внутреннего буфера фабрики во время выполнения, в количестве элементов
	static public $inner_cache = 100;
	//объекты кэшированные фабрикой
	static private $cache_pool = array();

	//функция вызывается для построения нового объекта
	static function build($class = 'D_Core_Object', $arguments = array()) {
		//echo "DUMPER {$class}";
		//если фабрика принимает на вход массив параметров то нам необходим сохранять кэш по полному списку параметров
		$arg = (sizeof($arguments) > 1) ? print_r($arguments,true) : $arguments[0];
		//генерируем строку по которой экземпляр класса будет хранится в кэше
		$cache_id = '__full_cache_for_'.$class.'_ID_'.$arg;

		// fast in-memory cache
		if(isset(self::$cache_pool[$cache_id])) {
			//echo "DAMNE";
			return self::$cache_pool[$cache_id];
		}

		//проверяем не был ли объект закэширован
		if(property_exists($class, 'cacheself') AND $class::$cacheself  != 0 AND isset(D::$cache->{$cache_id})) {
			$object = D::$cache->{$cache_id};
			if(is_object($object)) {
				return $object;
			} else throw new D_Core_Exception("Cached object ID: {$cache_id} is invalid.", EX_BAD_OBJECT);

		} else {
			// check if we have this class
			// by default CMS will try to autoload this class
			if(!class_exists($class)) {
				throw new D_Core_Exception("Class {$class} not found", EX_CLASS_NOT_FOUND);
			}

			// check if this class support fetching
			if(!method_exists($class,'__fetch')) {
				throw new D_Core_Exception("Fetch method for class {$class} not found.", EX_NO_FETCH_METHOD);
			}

			$object = call_user_func_array(array($class,'__fetch'), $arguments);
			// check if we found this object or not
			if(!is_object($object)) {
				throw new D_Core_Exception("Unable to find object of type {$class} with arguments: ".print_r($arguments, TRUE), EX_NO_SUCH_OBJECT);
			}
			if(property_exists($class, 'cacheself')) {
				//проверяем существует ли функция которую надо запускать перед тем как поместить объект в кэш
				if(method_exists($object,'__precache')) {
					call_user_func(array(&$object,'__precache'));
				}
				if($class::$cacheself > 0) D::$cache->set($cache_id,$object,$class::$cacheself);
				self::$cache_pool[$cache_id] = &$object;
			}
			if(method_exists($object, '__wakeup')) {
				$object->__wakeup();
			}
			return $object;
		}
	}

	static function __callStatic($class = 'D_Core_Object',$arguments = array('0')) {
		return self::build($class, $arguments);
	}

	/**
	 * Построение объекта по его ID
	 * @param string $id - строим объект из его ID
	 */
	static function getByID($id) {
		list($module, $class) = explode('://', $id);
		$data = explode('/', $class);
		$class_name = $module.'_'.str_replace('-','_',$data[0]);
		unset($data[0]);
		return self::build($class_name, array_values($data));
	}
}
?>