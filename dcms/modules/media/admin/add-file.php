<?php
$dirid = D::$req->textID('dir');
$mode = D::$req->textID('mode');
//загружаем каталог с которым мы хотим работать
try {
	//существует ли каталог в который будем добавлять
	$dir = D_Core_Factory::Media_Dir($dirid);
} catch (Exception $e) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NOT_SUCH_DIRECTORY'));
}

//найден ли файл
$file_source = D::$req->uploaded->files['mediafile'];
if(!$file_source) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_FILE_SOURCE'));
}
$media_file = new Media_File();
D::$req->map($media_file, array('filename'=>'textLine', 'descr' => 'bbText', 'variants' => 'bbText'));
//теперь загружаем. TODO Если на каком-то этапе проблемы и не отладка, удаляем загруженное
$media_file->parentid($dir->dirid)->from($file_source);
$media_file->saveConverted();
$media_file->saveThumb();
$media_file->save();
if($mode=='extend')
	$redirect=D::$req->referer();
//TODO Когда в корне, редиректит на media/dir_*** надо добавить Index
else $redirect=D::$req->referer() . '/dir_' . $dir->dirid;
D::$tpl->RedirectOrJSON($redirect, array('status' => 'OK'));
?>