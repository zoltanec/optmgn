<?php
try {
	$section = D_Core_Factory::News_Sections(D::$req->int('sid'));
} catch (Exception $e) {
	D::$Tpl->Redirect('~/list-sections/err_NO_SUCH_SECTION/');
}
$section->updPriority(D::$req->select('mode', array('up', 'down')));
$section->save();
D::$Tpl->Redirect('~/list-sections/');
?>