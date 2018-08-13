<?php
$section_need = D::$req->textLine('param1');
if(empty($section_need)) {
	$section_need = 'all';
}
try {
	$section = D_Core_Factory::News_Sections($section_need);
} catch(Exception $e) {
	D::$Tpl->Redirect('~/archive/');
}
$T['section'] = &$section;
$T['newslist'] = $section->getNewsList();
$T['newslist']->perpage(20)->page(D::$req->page('param2'));
?>