<?php
class Store_Category extends D_Core_Object {
	use D_Db_ActiveRecord;
    //Категория
    public $category_id;
    public $category_name;
    public $category_pid;
	//Описание категории
    public $descr;
    //Страна производителя
    public $country_id;
    //Псевдоним
    public $category_code;
    //Логотип
    public $category_logo;
    public $custom_tpl = 0;
    public $priority = 0;
    public $offset;


    static protected function __pk() {
    	return ['category_id'];
    }
    static protected function __table() {
    	return '#PX#_store_categories';
    }
    static protected function __fields() {
    	return ['category_name', 'category_code', 'category_pid', 'title', 'keywords', 'descr', 'category_logo', 'custom_tpl', 'active', 'priority', 'export_code'];
    }

    static function __fetch($category, $mode = 'standart') {
    	// root category is virtual
    	if( $category === 0 ) {
    		$dir = new self();
    		$dir->category_id  = 0;
    		$dir->category_pid = 0;
    		$dir->category_code = 'root';
    		return $dir;
    	}

    	if($mode == 'export') {
    		$cond = " export_code = '".$category."'";
    	} else {
    		$cond = (is_numeric($category)) ? " category_id = '".intval($category)."'" : " category_code = '{$category}'";
    	}
        return D::$db->fetchobject("SELECT * FROM #PX#_store_categories WHERE {$cond} LIMIT 1",__CLASS__);
    }

    protected function __get_name() {
    	return $this->category_name;
    }

    protected function __get_catid() {
    	return $this->category_id;
    }

    protected function __get_code() {
    	return $this->category_code;
    }

    //!Сохранение
	protected function __save() {
		// categories with empty names will recieve transliterated codes
		if($this->category_code == '' ) {
			$this->category_code = strtolower(preg_replace("/[^A-Za-z0-9_]+/","_", D::$i18n->translit($this->category_name)));
		}
		return $this->__save_record();
    }


    //!Получение родителя категории
    protected function __get_parent(){
    	return D_Core_Factory::Store_Category(intval($this->category_pid));
    }
	//!!!Получение всех родительских категорий
	protected function __get_parents(){
		$categories=array();
		$categories[]=$this->category_id;
		if($this->category_id!=0){
			foreach($this->parent->parents as $catid){
				$categories[]=$catid;
			}
		}
    	return $categories;
    }
	
    protected function __get_categories() {
    	return D::$db->fetchobjects("SELECT * FROM #PX#_store_categories WHERE category_pid = '{$this->category_id}' ORDER BY priority DESC",__CLASS__);
    }

    //!Получение подкатегорий
    function __get_children(){
    	return D::$db->fetchobjects("SELECT * FROM #PX#_store_categories WHERE category_pid = '{$this->category_id}'",__CLASS__);
    }
    //!Изменение приоритета отображения категорий
    function UpdatePriority($mode) {
    	$action = ($mode == 'up') ? '+1' : '-1';
    	D::$db->exec("UPDATE #PX#_store_categories SET priority = priority + ($action) WHERE category_id = {$this->category_id} LIMIT 1");
    }
    //!Получение категорий по ID родительской категории

    static function getCategoriesByPid( $category_pid = 0, $priority = true){
		if($priority)
			$order='ORDER BY priority DESC, category_name ASC';
		else $order='ORDER BY category_name ASC';
    	return D::$db->fetchobjects("SELECT * FROM #PX#_store_categories WHERE category_pid = '{$category_pid}' {$order}",__CLASS__);
    }
    //!Получение всех категорий
	static function getAllCategories() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_store_categories",__CLASS__);
	}

	protected function __get_sub_categories() {
		return Store_Category::getCategoriesByPid($this->category_id);
	}

	protected function __get_products() {
		return Store_Product::getProductsByCategory($this->category_id);
	}
	protected function __get_active_products() {
		return Store_Product::getProductsByCategory($this->category_id, true);
	}
	
	/**
	 * Get list of supported fields
	 */
	public function __get_fields() {
		//!!!
		$categories=$this->parents;
		//!!!
		return Store_Fields::getCategoryFieldsAssoc($categories);
	}
	//!Получение рекурсией массива дочерних категорий, включая родительскую по коду родительской
	//offset для получение уровня вложенности категории, для построения меню, иерархических селектов
	static function getChildCategories($pr_category, $offset=0, $include_root=false){
			if($pr_category=='root')
				$pr_category=0;
			//Массив наполняемый категориями
			$ch_categories=array();
			//Если в качестве параметра передан код категории
			if(!is_numeric($pr_category) || $include_root){
				$pr_category=self::__fetch($pr_category);
				$pr_category->offset=$offset;
				//Если флаг передан включать корневой каталог, заносим в массив
				$ch_categories[]=$pr_category;
				$pr_category=$pr_category->category_id;
			}
			$categories=self::getCategoriesByPid($pr_category);
			foreach($categories as $category){
                $category->offset=$offset;
                $ch_categories[]=$category;
                if(self::getChildCategories($category->category_id)!=NULL){
                    foreach(self::getChildCategories($category->category_id, ++$offset) as $category){
                        $category->offset=$offset;
                        $ch_categories[]=$category;
                    }
                }
			}
		return $ch_categories;
	}
}
?>
