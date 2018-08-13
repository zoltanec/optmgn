<?php
try {
	$dir = D_Core_Factory::Media_Dir(D::$req->textID('dir'));
	//удаляем каталог
	$dir->delete();
	D::$Tpl->redirect("~/ls/dir_{$dir->parentid}/");
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/ls/dir_root/', array('status' => 'ERROR_NOT_SUCH_DIRECTORY'));
}
?>