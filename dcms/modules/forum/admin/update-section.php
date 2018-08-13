<?php
//получаем раздел
$section = dObject::ForumSection(D::$req->int('sid'));
//если рездел существует
if($section) {
	//теперь забиваем все переменные
	D::$req->map($section, array('cid'=> 'int', 'name'=> 'textLine', 'descr'=> 'bbText', 'active' => 'flag', 'readonly'=> 'flag'));
	$section->save();
	D::$Tpl->redirect('~/edit-section/sid_'.$section->sid.'/');
}
D::$Tpl->redirect('~/');
?>