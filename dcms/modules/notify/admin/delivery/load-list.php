<?php
try {
	$list = D_Core_Factory::Notify_Delivery_Lists(D::$req->int('lid'));
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_LIST');
}
$file = D::$req->textID('file');
$data = $list->loadFromFile(D::$config->work_dir."/".$file);
?>