<?php
try {
	$section = D_Core_Factory::News_Sections(D::$req->int('sid'));
} catch(Exception $e) {
	D::$Tpl->Redirect('~/list-sections/');
}
$T['section'] = $section;
?>