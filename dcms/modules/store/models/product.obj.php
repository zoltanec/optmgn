<?php
//комментарии
class Store_Product extends D_Core_Object {
	use D_Db_ActiveRecord;
	use Core_I18n_Localizeable;
	use Core_LogAble;

    static $cacheself = 200;
    //Идентификатор продукта
    public $prod_id = 0;
    //Артикул продукта
    public $article_id = 0;
    //Наличие на складе (количество)
    public $available = 1;
    //Единица измерения
    public $units;
    //Название продукта
    public $prod_name = 'NEW_PRODUCT';
    //Тип продукта
    public $prod_type = 0;
    //Описание продукта
    public $descr = '';
    public $export_code = '';
    public $reciple;
    //Цена продукта
    public $price = 0;
    //Производитель
    public $producer_id = 0;
    public $producer_name;
    //Страна
    public $country_name;
    //Категория
    public $category_name;
    public $category_id = 0;
    //Номер скидки
    public $discount_id = 0;
    public $short_name = '';
    //Рейтинг
    public $rate = 0;
   	//Доставка
    public $delivery = 0;
    public $psc = 0;
    public $weight = 0;
    //Дата добавления
    public $add_time = 0;
    //Дата обновления
    public $upd_time = 0;
    public $active = 1;
    public $mix = '';

    static public $base_query = "SELECT a.*, b.producer_name, d.category_id, d.category_name, d.category_code FROM #PX#_store_products a
    LEFT OUTER JOIN #PX#_store_producers b using(producer_id)
    LEFT OUTER JOIN #PX#_store_categories d using(category_id)";

    static function __fetch($prod_id, $mode = 'normal') {

   		$cond = ($mode == 'export') ? ' a.export_code = "'.$prod_id.'" ' : "prod_id = '{$prod_id}'";
       	return D::$db->fetchobject(self::$base_query." WHERE {$cond} LIMIT 1",__CLASS__);
    }
	
    /*Get Price without sale*/
	function getDefPrice() {
		if(isset($this->fields['wholesale-price']) && $this->fields['wholesale-price']->content) {
			$current_price=$this->fields['wholesale-price']->content;
		}else{
			$current_price=$this->price;
		}
        return $current_price;
    }
    /*Get Price with sale*/
	function getCurrentPrice() {
		if(isset($this->fields['wholesale-discount-price']) && $this->fields['wholesale-discount-price']->content) {
			$current_price=$this->fields['wholesale-discount-price']->content;
		}else{
			$current_price=$this->price;
		}
		return $current_price;
    }
    
    /*Количество в одной коробке*/
    public function getBoxQt() {
        $boxQt = false;
        if (isset($this->fields['wholesale-size']) && $this->fields['wholesale-size']->content) {
            $sizes = unserialize($this->fields['wholesale-size']->content);
            if ($sizes) {
                foreach ($sizes as $cols) {
                    if ($cols['checked'] && $cols['value']) {
                        $boxQt += $cols['value'];
                    }
                }
            }
        } else {
            $boxQt = 1;
        }

        return $boxQt;
   }
    
    /**
	 * Get product short name
     */
	function getShortName($limit = 25){
		if(!empty($this->short_name)) return $this->short_name;

		if(mb_strlen($this->prod_name) > $limit)
			return mb_substr( $this->prod_name, 0 , $limit - 3).'&nbsp;&#8230;';

		return $this->prod_name;
	}
	
    function __get_description(){
		if ( substr($this->descr, -1, 1) != '.' ) { 
			$this->descr.='.';
		}
		return $this->descr;
	}
	
    static protected function __table() {
		return '#PX#_store_products';
	}
	
    static protected function __pk() {
		return ['prod_id'];
	}
	
    static protected function __fields() {
		return ['article_id', 'available', 'title', 'short_name', 'prod_name', 'export_code', 'descr', 'price', 'producer_id', 'category_id', 'discount_id', 'rate', 'delivery', 'psc', 'mix',  'weight',   'bestseller',  'priority',  'active', 'upd_time'];
	}

    protected function __save() {
		return $this->__save_record();
    }
    
    //!Получение родительской категории
    function __get_parent_category(){
    	if($this->category_pid==0)
    		return D_Core_Factory::Store_category($this->category_id);
    	return D_Core_Factory::Store_category($this->category_id);
    }

    /**
     * Родительский каталог
     */
    function __get_parent() {
    	return D_Core_Factory::Store_Category(intval($this->category_id));
    }

    function __get_picture() {
    	try {
    		return $this->images->picfiles[0];
    	} catch (Exception $e) {
    		return NULL;
    	}
    }

    protected function __get_bids() {
    	try {
    		$bid = D_Core_Factory::Store_Bids_Sessions($this->prod_id);
    	} catch (Exception $e) {
    		$bid = new Store_Bids_Sessions();
    		$bid->prod_id = $this->prod_id;
    		$bid->str_time = time();
    		$bid->cls_time = time() + D_Core_Time::SECONDS_IN_DAY * 7;
    	}
    	return $bid;
    }
    
    function __get_pictures() {
	$media = D_Core_Factory::Media_Dir("product".$this->prod_id);
		return $media->picfiles;
    }
    
    protected function __get_images() {
    	return D_Core_Factory::Media_Dir("product".$this->prod_id);
    }

    protected function __get_fields() {
    	return Store_FieldsValues::getForProduct($this->prod_id);
    }

    protected function __get_name() {
    	return $this->prod_name;
    }

    //!Получение следующего продукта
    function getNextProduct($mode) {
    	//$action = ($mode == 'up') ? $this->prod_id+1 : $this->prod_id-1;
    	return D::$db->fetchobject(self::$base_query." ORDER BY a.priority DESC LIMIT 1 OFFSET 3s",__CLASS__);
    }

    //!Изменение приоритета продукта
	function UpdatePriority($mode) {
    	$action = ($mode == 'up') ? '+1' : '-1';
    	D::$db->exec("UPDATE #PX#_store_products SET priority = priority + ($action) WHERE prod_id = {$this->prod_id} LIMIT 1");
    }

    static function getPopularProducts() {
    	return D::$db->fetchobjects(self::$base_query." WHERE a.active AND a.bestseller ORDER BY a.priority DESC LIMIT 20",__CLASS__);
    }

    static function getProductsList($name) {
    	return D::$db->fetchobjects("SELECT b.* FROM #PX#_store_lists a LEFT OUTER JOIN #PX#_store_products b USING (prod_id) WHERE a.name = :name ORDER BY a.priority ASC",__CLASS__,[':name' => $name]);
    }

    protected function __get_nearest() {
    	$prods = self::find(['category_id' => $this->category_id, 'active' => 1]);
    	$total = sizeof($prods);
    	for($x = 0; $x < $total; $x++){
    		if($prods[$x]->prod_id == $this->prod_id) {
    			$prev = (isset($prods[$x-1])) ? $prods[$x-1] : $prods[$total-1];
    			$next = (isset($prods[$x+1])) ? $prods[$x+1] : $prods[0];
    			return ['prev' => $prev, 'next' => $next];
    		}
    	}
    	return ['prev' => '', 'next' => ''];
    }

    //!Получение всех продуктов
    static function getAllProducts() {
    	return D::$db->fetchobjects(self::$base_query." ORDER BY a.priority DESC",__CLASS__);
    }
    
	static function getRandomProducts($categories=array()){
	foreach($categories as $category){
		foreach(Store_Category::getChildCategories($category) as $for_category){
			$allcategories[]=$for_category->category_id;
		}
	}
	$result=self::getBySearchCond("(category_id=".implode(" OR category_id=",$allcategories).")",$order='Rand()');
	$result->perpage=D::$config->{'store.main_perpage'};
	return $result;
    }
    
	//!Получение продукта по родительской категории
	static function getProductsByCategoryy($category_id){
		return self::getBySearchCond("category_id=".$category_id, 'a.prod_name ASC')->fetchPage();
	}
    
	//!Получение всех продуктов по родительской категории
    static function getProductsByCategory($category_id, $active = false, $cond=""){
    	$category = [$category_id];
    	foreach(Store_Category::getChildCategories($category_id) as $for_category){
    		$category[] = $for_category->category_id;
    	}
		$active_filter = ($active) ? ' AND a.active ' : '';
		if(is_array($cond) && count($cond)) {
			$cond = " AND " . implode(" AND ", $cond);
        } else {
            $cond = '';
        }
		return self::getBySearchCond("(category_id=" . implode(" OR category_id=", $category) . "){$cond}{$active_filter}");
    }
    
    //!Получение продукта по какому либо параметру
	static function getBySearchCond($cond='',$order='a.priority DESC') {
		$total_query = "SELECT COUNT(1) FROM #PX#_store_products";
		if (is_array($cond)) {
			foreach($cond as $field=>$val) {
				if ($val)
					$query_cond[] = $field . "='" . $val . "'";
				else $query_cond[] = $field;
			}
		} else {
            $query_cond[] = $cond;
        }
		$searcher = new D_Core_List();
		$condition = "";
		if ($cond) {
			$condition = " WHERE " . implode(' AND ',$query_cond);
        }
		$searcher->total_query = $total_query . $condition;
		$searcher->fetch_query = self::$base_query . $condition . ' ORDER BY ' . $order;
		$searcher->perpage = D::$config->{'store.products_perpage'};
		$searcher->container = __CLASS__;
		return $searcher;
	}
    
	//!Сортировка продукта по дополнительным полям
	static function sortByFields($prods, $sorting) {
		//$sorting=array('dimentions'=>'2','price'=>array('max'=>10,'min'=>'1000'));
		$sort=array();
		$flag;
		foreach($prods as $prod){
			$flag=true;
			if(is_array($sorting)){
				foreach($sorting as $field => $field_val){
                    if(!$field_val) {
                        continue;
                    }
					if($field == 'price' && is_array($field_val)) {
						if(isset($prod->fields[$field])){
                            if($prod->fields[$field]->content < $field_val['min'] || $prod->fields[$field]->content > $field_val['max']){
                                $flag=false;
                                break;
                            }
						} else {
                            if($prod->price < $field_val['min'] || $prod->price > $field_val['max']){
                                $flag=false;
                                break;
                            }
                        }
					} elseif($field == 'sex') {
                        if(($prod->category_code == 'womenwear' || $prod->category_code == 'womenfootwear') && $field_val == 'man') {
                            $flag=false;
                            break;
                        }
                        if(($prod->category_code == 'manwear' || $prod->category_code == 'manfootwear') && $field_val == 'women') {
                            $flag=false;
                            break;
                        }
                    } elseif($field == 'search') {
                        if(!preg_match('#' . mb_strtolower($field_val) . '#', mb_strtolower($prod->fields['brand']->content . ' ' . $prod->prod_name), $match)) {
                            $flag = false;
                        }
                    } elseif(is_array($field_val)) {
                        if(!isset($prod->fields[$field])) {
                            $flag=false;
                            break;
                        }
                        foreach($field_val as $multiField) {
                            if(!$multiField) {
                                continue;
                            }
                            
                            if($field == 'size') {
                                $availableSizes = unserialize($prod->fields[$field]->content);
                                if(isset($availableSizes[$multiField]) && $availableSizes[$multiField]['value'] != 0 && $availableSizes[$multiField]['checked']) {
                                    $flag=true;
                                    break;
                                } else {
                                    $flag=false;
                                }
                            } else {
                                if($prod->fields[$field]->content == $multiField){                                    
                                    $flag=true;
                                    break;
                                } else {
                                    $flag=false;
                                }
                            }
                        }
                        if(!$flag) {
                            break;
                        }
                    } elseif (!isset($prod->fields[$field]) || $prod->fields[$field]->content != $field_val) {
							$flag=false;
                            break;
					}
				}
			} else{
				if(!isset($prod->fields[$sorting])){
					$flag=false;
				}
			}
            
			if($flag)
				$sort[] = $prod;
		}
		return $sort;
	}
	//!Отображения существующих значений поля
	static function getFieldVariants($products,$code){
		$prods_id=array();
		foreach($products as $prod){
			$prods_id[]=$prod->prod_id;
		}
		$cond='(prod_id='.implode(' OR prod_id=', $prods_id).')';
		$variants=D::$db->fetchlines("SELECT content FROM #PX#_store_categories_fields_values WHERE {$cond} and code = '{$code}' GROUP BY content ORDER BY content");
		array_walk($variants, function(&$item){
			$item=$item['content'];
		});
		return $variants;
	}

}
?>
