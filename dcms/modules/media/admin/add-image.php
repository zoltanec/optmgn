<?php
//вложенная директория для сохранения
//TODO объединить object_id и object
$object_id = D::$req->raw('object_id');
//Модуль куда сохранять
$module = D::$req->textID('module');
//откуда брать настройки global или object
$object = D::$req->textID('object');
//Название файла
$fileid = D::$req->textID('file_id');
$mode = D::$req->textID('mode');
//var_dump($object_id);exit;

//mode - icon , iteration
//file_id меняем дестинатион
$uploaded_files = D::$req->uploaded->files['file'];
//найден ли файл
if(!count($uploaded_files)) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_FILE_SOURCE'));
}
//D::$req->map($media_file, array('filename'=>'textLine', 'descr' => 'bbText', 'variants' => 'bbText'));
//теперь загружаем. TODO Если на каком-то этапе проблемы и не отладка, удаляем загруженно
	
foreach($uploaded_files as $index => $file_source) {
    //Настройки берем из вызываемого модуля
    Core_SettingValue::$module = $module;
    Core_SettingValue::$object = $object;
    $media_file = new Media_File();
    $media_file->parentid($object_id);
    $media_file->from($file_source);

	if(isset($fileid)) {
        if($mode == 'iteration' || count($uploaded_files) > 1) {
            $fileMeta = $fileid . $index;
        } else {
            $fileMeta = $fileid;
        }
        $media_file->fileid = $media_file->replaceToMyMeta($fileMeta . '.#ext#');
    }
	$media_file->saveConverted();
	$media_file->saveThumb();
    $media_file = null;
}
//Уничтожаем объект и сбрасываем настройки
//if mode_save_to_media
//$media_file->save();
$redirect = D::$req->referer();
D::$tpl->RedirectOrJSON($redirect, array('status' => 'OK', 'mode' => $mode, 'fileId' => $fileid , 'total' => count($uploaded_files)));
?>