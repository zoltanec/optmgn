<?php
//!класс базовый для объектов CMS
abstract class D_Core_Object {

	const CACHE_LOCAL_PREFIX = '_cache_';

	//!список переменных доступных для кэширования
	static protected $cacheable = array();
	//!время кэширования статических вызовов
	static protected $cachestatic = array();
	//!кэширование с плавной заменой контента
	static protected $cachehard = array();
	// объекты кэшированные в данном запуске
	static protected $cachednow = array();

	/**
	 * Default getter with memoization support
	 *
	 * @param string $name - variable name
	 */
	public function __get($name) {
		// if we don't have getter for this property we can run final getter implemented
		// in this class, or we will return nothing
		if(!method_exists($this, '__get_'.$name)) {
			if (!method_exists($this, '__get_final')) {
				return false;
			}
			return $this->__get_final($name);
		}

		// save cache options
		$classname = get_called_class();
		$cacheable = $classname::$cacheable;
		$cachehard = $classname::$cachehard;

		// this variable is not cacheable, return it right now
		if(!isset($cacheable[$name])) {
			return call_user_func(array($this,'__get_'.$name));
		}

		// if this is a short caching, dump it and return variable
		if( $cacheable[$name] == 0 ) {
			return ( $this->{$name} = call_user_func(array($this, '__get_'.$name)) );
		}

		$long_cache_id = $this->object_id().".cached.".$name;
		// looks like we want have long cache, return it
		if(isset(D::$cache->{$long_cache_id})) {
			return ( $this->{$name} = D::$cache->{$long_cache_id} );
		}

		// check if we have hard cache
		if(isset($cachehard[$name])) {
			$hard_cache_id = $this->object_id().".hrdata.".$name;
			$lock_code = '__lock_'.$long_cache_id;
			$hard_cache_lock = "__hardlock_".$long_cache_id;

			// looks like somebody is building cache, but we have old hard cache, return it
			if(isset(D::$cache->{$hard_cache_lock}) && isset(D::$cache->{$hard_cache_id})) {
				return ( $this->{$name} = D::$cache->{$hard_cache_id} );
			}

			D::$cache->set($hard_cache_lock, $lock_code, $cacheable[$name] );
			// если результат запроса не получен из кэша тяжелых элементов
			$this->{$name} = call_user_func(array($this, '__get_'.$name));
			D::$cache->set($hard_cache_id, $this->{$name}, $cacheable[$name] * 100);

		} else {
			$this->{$name} = call_user_func(array($this, '__get_'.$name));
		}

		D::$cache->set($long_cache_id, $this->{$name}, $cacheable[$name]);
		return $this->{$name};
	}

	/**
	 * Выполняем запуск геттеров для указанного набора данных, для упреждающего кэширования
	 * @param mixed $variables - список переменных
	 */
	function touch($toTouch = array()) {
		if(is_array($toTouch)) {
			$variables = $toTouch;
		} else {
			$variables = array($toTouch);
		}

		//!теперь обходим все переменные
		foreach($variables AS $varname) {
			if(!method_exists($this, '__get_'.$varname)) {
				continue;
			}
			$cache_id = self::CACHE_LOCAL_PREFIX.$varname;
			$this->{$cache_id} = call_user_func(array($this,'__get_'.$varname));
		}
	}

	/**
	 * Generate object ID string
	 */
	function object_id() {
		$class_parts = explode('_', get_called_class());
		$result = $class_parts[0]."://";
		$object_id = $this->__object_id();
		unset($class_parts[0]);
		$result .= implode('-', $class_parts).'/'.implode('/', $this->__object_id());
		return strtolower($result);
	}

	/**
	 * Flush cached vars
	 */
	function untouch($toUnTouch = array(), $cleanCacher = false) {
		if(is_array($toUnTouch)) {
			$variables = $toUnTouch;
		} else {
			$variables = array($toUnTouch);
		}
		foreach($variables AS $varname) {
			$cache_id = self::CACHE_LOCAL_PREFIX.$varname;
			if(isset($this->{$cache_id})) {
				unset($this->{$cache_id});
			}
			if($cleanCacher) {
				$long_cache_id = $this->object_id().".cached.".$varname;
				D::$cache->delete($long_cache_id);
			}
		}
	}

	/**
	 *
	 * Функция устнавливает значение для несуществующих в классе свойств
	 * @param string $name имя переменной
	 * @param $value
	 */
	function __set($name,$value) {
		if($name[0] == '_') {
			$this->{$name} = $value;
			return;
		}
		//!если данная функция задана у класса
		if(method_exists($this,'__set_'.$name)) {
			$cache_id = self::CACHE_LOCAL_PREFIX.$name;
			$result = call_user_func_array(array($this,'__set_'.$name),array($value));
			$this->untouch($name);
			$this->{$cache_id} = $result;
			return $result;
		} else {
			$this->{$name} = $value;
		}
	}

	/**
	 * Call for non-existed function
	 * @param string $method - called method
	 * @param array $args - arguments
	 */
	function __call($method,$args) {
		//массив аргументов должен содержать только один элемент
		if(sizeof($args) == 1 ) {
			//если у нас есть переменная с именем метода то
		 	if(isset($this->{$method})) {
				//если существует специальная функция для обработки данных
				if(method_exists($this, '__check_'.$method)) {
					call_user_func_array(array($this,'__check_'.$method),$args);
				} else $this->{$method} = $args[0];
				return $this;
			} elseif(method_exists(get_called_class(), '__'.$method)) {
				$classname = get_called_class();
				//параметры кэширования вызовов статических функций
				$cachestatic = $classname::$cachestatic;
				//идентификатор по которому будет кэширован результат вызова метода
				$long_cache_id = '__static_call_'.strtolower($classname.'_arg_'.$method).'_ARG_'.md5(serialize($args));
				if(isset($cachestatic[$method])) {
					//если мы уже ранее кэшировали данный вызов с указанным списком параметров
					if(isset(D::$cache->{$long_cache_id})) {
						return D::$cache->{$long_cache_id};
					//похоже кэшировать мы хотим, но сейчас мимо кэша попали
					} else {
						$result = call_user_func_array(array($classname,'__'.$method),$args);
						D::$cache->set($long_cache_id, $result, $cachestatic[$method]);
						return $result;
					}
				} else {
					return call_user_func_array(array($classname,'__'.$method),$args);
				}
			} else {
				//проверяем наличие виртуального метода
				if(method_exists($this,'__get_'.$method)) {
					if(method_exists($this, '__set_'.$method)) {
						call_user_func_array(array($this,'__set_'.$method),$args);
					} else trigger_error("Can't assign variable with virtual getter!",E_USER_ERROR);
				} else {
					if(method_exists($this,'__set_'.$method)) {
						call_user_func_array(array($this,'__set_'.$method),$args);
					} else {
						$this->{$method} = $args[0];
					}
				}
				return $this;
			}
		}
	}

	/**
	 *
	 * Call static function
	 *
	 * @param string $method - requested method
	 * @param array $arguments - arguments for function
	 *
	 **/
	public static function __callStatic($method, $arguments = []) {
		$classname = get_called_class();
		$cachestatic = $classname::$cachestatic;

		$long_cache_id = '__static_call_'.strtolower($classname.'_arg_'.$method).'_ARG_'.md5(serialize($arguments));

		if(isset(self::$cachednow[$long_cache_id])) {
			return self::$cachednow[$long_cache_id];
		}

		// callind method which was not implemented in this class
		if(!method_exists(get_called_class(), '__'.$method)) {
			throw new D_Core_Exception("Unknown method {$method} for ".get_called_class()." class.", EX_NO_SUCH_METHOD);
		}

		// calling function without cache, for debug purposes
		if(!isset($cachestatic[$method])) {
			return call_user_func_array(array($classname,'__'.$method), $arguments);
		}

		// cache for long function calls
		$cachehard   = $classname::$cachehard;
		// check long cached calls for this stuff
		if(isset(D::$cache->{$long_cache_id})) {
			return ( self::$cachednow[$long_cache_id] = D::$cache->{$long_cache_id} );
		}

		$hard_cache_id = '__hard_'.$long_cache_id;
		// looks like cache is missed, let's check hard cache if available
		if(isset($cachehard[$method])) {
			$lock_code = md5(rand());
			$hard_cache_lock = "__lock_".$long_cache_id;

			// if this call was locked then return hard cache
			if(!isset(D::$cache->{$hard_cache_lock})) {
				D::$cache->set($hard_cache_lock, $lock_code, $cachestatic[$method]);
			} else {
				if(isset(D::$cache->{$hard_cache_id})) {
					return D::$cache->{$hard_cache_id};
				}
			}
		}

		$result = call_user_func_array(array($classname,'__'.$method),$arguments);

		if(isset($cachehard[$method])) {
			D::$cache->set($hard_cache_id, $result, $cachestatic[$method] * 100);
		}
		D::$cache->set($long_cache_id, $result, $cachestatic[$method]);
		return ( self::$cachednow[$long_cache_id] = $result );
	}

	/**
	 * Flush object cache if properties was changed
	 */
	function flush($class = '', $id = 0) {
		if(method_exists($this, '__flush')) {
			$id = call_user_func(array($this, '__flush'));
			$class = get_called_class();
		}
		if(is_array($id)) {
			$id_code = print_r($id,true);
		} else {
			$id_code = $id;
		}
		D::$cache->delete('__full_cache_for_'.$class.'_ID_'.$id_code);
	}

	/**
	 * Save object instance
	 */
	function save() {
		$id = $this->__save();
		$this->flush(get_called_class(), $id);
		if(method_exists($this, "__precache")) {
			$this->__precache();
		}
		return $id;
	}

	/**
	 * Delete object
	 */
	function delete() {
		$id = $this->__delete();
		$this->flush(get_called_class(), $id);
		return $id;
	}

	/**
	 * Object-ID hash
	 */
	function object_hash() {
		return md5(strtolower($this->object_id()));
	}
}