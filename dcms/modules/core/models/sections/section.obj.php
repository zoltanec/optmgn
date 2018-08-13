<?php
class Core_Sections_Section extends D_Core_Object {
    //Категория
    public $sid;
    //Родительская категория
    public $pid;
    //Имя категории
    public $section_name;
    //Код категории
    public $section_key;
	//Описание категории
    public $descr;
    //Страна производителя
    public $module_name;
    //Флаг активности
    public $active;
    //Приоритет
    public $priority;

    static function __fetch($section) {
    	if(is_numeric($section))
    		$cond="sid={$section}";
        else $cond="section_key='{$section}'";
        return D::$db->fetchobject("SELECT * FROM #PX#_core_sections WHERE {$cond} LIMIT 1",__CLASS__);
    }

    function object_id() {
		return $this->sid;
	}
	function delete() {
        D::$db->exec("DELETE FROM #PX#_core_sections WHERE sid={$this->sid} LIMIT 1");
	}
    //!Сохранение
	protected function __save() {
		$i18n=new D_Core_i18n();
		$this->section_key=preg_replace("/[^A-Za-z0-9_]+/","_",$i18n->translit($this->section_name));
		if($this->sid==0)
			D::$db->exec("INSERT INTO #PX#_core_sections (pid,
														 section_name,
														 section_key,
														 descr, 
														 image,
														 module_name)
												VALUES ('{$this->pid}',
														'{$this->section_name}',
														'{$this->section_key}',
														'{$this->descr}',
														'{$this->image}',
														'{$this->module_name}')");
		else D::$db->exec("UPDATE #PX#_core_sections SET section_name = '{$this->section_name}',
														 section_key='{$this->section_key}',
														 pid={$this->pid},
		    	                						 descr = '{$this->descr}',
														 image='{$this->image}' WHERE sid={$this->sid}");
		return $this->sid;
    }
    //!Получение родителя категории
    function __get_parent(){
    	return D::$db->fetchobject("SELECT * FROM #PX#_core_sections WHERE sid={$this->pid} LIMIT 1",__CLASS__);
    }
    //!Изменение приоритета отображения категорий
	function UpdatePriority($mode) {
    	$action = ($mode == 'up') ? '+1' : '-1';
    	D::$db->exec("UPDATE #PX#_core_sections SET priority = priority + ($action) WHERE sid = {$this->sid} LIMIT 1");
    }
    //!Получение категорий по ID родительской категории
    static function getSectionsByPid($pid, $module_name=""){
    	if($module_name)
    		$cond=" WHERE module_name='{$module_name}' AND pid={$pid}";
    	else $cond=" WHERE pid={$pid}";
    	return D::$db->fetchobjects("SELECT * FROM #PX#_core_sections".$cond." ORDER BY priority DESC",__CLASS__);
    }
    //!Получение всех категорий
	static function getAllSections($module_name="") {
		if($module_name)
			$module_name=" WHERE module_name='{$module_name}'";
		return D::$db->fetchobjects("SELECT * FROM #PX#_core_sections".$module_name,__CLASS__);
	}
	//!Получение рекурсией массива дочерних категорий, включая родительскую по коду родительской
	static function getChildSections($pr_section, $module_name=""){
		//Массив наполняемый категориями
		$ch_sections=array();
		//Если в качестве параметра передан код категории
		if(!is_numeric($pr_section)){
			$pr_section=self::__fetch($pr_section);
			$ch_sections[]=$pr_section;
			$pr_section=$pr_section->sid;
		}
		$sections=self::getSectionsByPid($pr_section,$module_name);
		foreach($sections as $section){
				$ch_sections[]=$section;
				if(self::getChildSections($section->sid,$module_name)!=NULL){
					foreach(self::getChildSections($section->sid,$module_name) as $section){
						$ch_sections[]=$section;	
					}
				}
		}
		return $ch_sections;
	}
}
?>