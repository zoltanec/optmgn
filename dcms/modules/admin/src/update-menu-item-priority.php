<?php
$item = D_Core_Factory::Admin_MenuItem(D::$req->int('itemid'));
$item->setPriority(D::$req->select('mode', array('up','down')));
$item->save();
D::$Tpl->Redirect('~/menu-items/');
?>