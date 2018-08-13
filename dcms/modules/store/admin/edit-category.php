<?php
$category = D_Core_Factory::Store_Category(D::$req->int('catid'));

$T['category'] = &$category;
// working with breadcrumbs
$dir = $T['category'];
D::$tpl->startBcReverse();

while(1) {
	try {
		$dir = $dir->parent;
		if($dir->category_id == $dir->category_pid) break;
		D::$tpl->addBC('~/edit-category/catid_'.$dir->category_id, $dir->category_name);
	} catch (Exception $e) {
		//var_dump($dir);exit;
		break;
	}
}
D::$tpl->addBC('~/edit-category/catid_0', 'Root');
D::$tpl->stopBcReverse();
?>
