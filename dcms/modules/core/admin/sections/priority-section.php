<?php
$sid = D::$req->int('sid');
$mode = D::$req->select('mode' , array('up', 'down'));
$section = D_Core_Factory::Core_Sections_Section($sid);
if(!$section) {
	D::$Tpl->redirect('~/');
}
$section->UpdatePriority($mode);
D::$Tpl->redirect(D::$req->referer());
?>