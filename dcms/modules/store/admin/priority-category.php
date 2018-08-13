<?php
$categoryid = D::$req->int('category');
$mode = D::$req->select('mode' , array('up', 'down'));
$category = D_Core_Factory::Store_Category($categoryid);
if(!$category) {
	D::$Tpl->redirect('~/');
}
$category->UpdatePriority($mode);
D::$Tpl->redirect(D::$req->referer());
?>