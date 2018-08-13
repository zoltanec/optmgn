<?php
$prod=D_Core_Factory::Store_Product(D::$req->int('pid'));
$prod->delete();
D::$Tpl->redirect(D::$req->referer());
?>