<?php
$prodid = D::$req->int('pid');
$mode = D::$req->select('mode' , array('up', 'down'));
$prod = D_Core_Factory::Store_Product($prodid);
if(!$prod) {
	D::$Tpl->redirect('~/');
}
$prod->UpdatePriority($mode);
D::$Tpl->redirect(D::$req->referer());
?>