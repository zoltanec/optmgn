<?php
/*
* Вывод меню сайта в фронтенде
*/
Class Pages_Menu {
	
	static function isMapPage() {
		if(D::$req->action == 'map' && D::$req->module=='pages')
			return true;
		else return false;
	}
	
	static function isMainActive() {
		$default_module=D::$config->default_module;
		if( D::$req->module == $default_module && ( D::$req->action == '' || D::$req->action == 'index') )
			return true;
		return false;
	}
	
	static function getMenuTree($parent_id) {
		if(!$parent_id)
			$parent_id = 0;
		try {
			if( !self::isMainActive() && !self::isMapPage() && D::$req->module=='pages') {
				$page = D_Core_Factory::Pages_StaticPage(D::$req->action, D::$req->lang, 'name');
				$page_parents = $page->getParentsList('content_id');
				//Поиск открытых узлов-родителей текущей страницы
				if(in_array($parent_id, $page_parents)) {
					$opened = $page->getParentsList('alias', $parent_id);
					$opened[] = $page->alias;
				}
			}
			
			$tree=Pages_StaticPage::getTreeArray($parent_id,false);
			if($page && isset($opened)) {
				//Ставим метку на открытые узлы и активный пункт меню
				$tmp_var = $tree;
				foreach($opened as $key=>$open_parent) {
					
					$node = $tmp_var[$open_parent];
					if (!isset($node)) 
						$node = new stdClass();
					//if( $open_parent == $page->alias ) {
					//	$node->node_active = true;
					//} else {
						$node->node_opened = true;
					//}
					$tmp_var = $tmp_var[$open_parent]->childrenTree;
				}
			}
			return $tree;
		} catch (Exception $e) {
			throw new D_Core_Exception('TREE ERROR');
		}
	}
}
?>