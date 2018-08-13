<?php
/**
 * Display tree objects, default plugins for pages module
 */
function smarty_function_show_tree($params, &$smarty) {
	//init setting for current module
	Core_SettingValue::$module = $params['module'];
	if ( !isset($params['tpl_path']) ) {
		$tpl_path = "dit:pages;admin/";
	} else {
		$tpl_path = $params['tpl_path'];
	}
	$params['tree_paragraph']++;
	$tree_object = $params['tree_object'];
	$len = count($tree_object); 
	
	foreach ( $tree_object as $tree_node ) {
		$smarty->assign('tpl_path', $tpl_path);
		$smarty->assign('tree_node', $tree_node);
		$smarty->assign('tree_paragraph',$params['tree_paragraph']);
		//default from config
		if(!$params['menu_type'])
			$smarty->assign('menu_type',D::$config->setting->menu_orientation);
		else $smarty->assign('menu_type',$params['menu_type']);
		$smarty->assign('img_path',$params['img_path']);
		$smarty->assign('level',$params['level']);
		
		if( count($tree_node->childrenTree) ) {
			$smarty->assign('tree_object',$tree_node->childrenTree);
			$smarty->assign('tree_childrens',count($tree_node->childrenTree));	
			$smarty->display($tpl_path.'tree_subnode');
		} else {
			$smarty->display($tpl_path.'tree_node');
		}
	}
	return;
}
?>