<?php

$T['prod'] = D_Core_Factory::Store_Product(D::$req->int('pid'));


$dir = $T['prod']->parent;
D::$tpl->startBcReverse();
D::$tpl->addBC('~/edit-category/catid_'.$dir->category_id, $dir->category_name);
while(1) {
	try {
		$dir = $dir->parent;
		if($dir->category_id == $dir->category_pid) break;

		D::$tpl->addBC('~/edit-category/catid_'.$dir->category_id, $dir->category_name);
	} catch (Exception $e) {
		break;
	}
}
D::$tpl->addBC('~/edit-category/catid_0', 'Root');
D::$tpl->stopBcReverse();
?>