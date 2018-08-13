<?php
$videos = D::$db->fetchobjects("SELECT * FROM #PX#_media_files WHERE type = 'video'",'MediaFile');
foreach($videos AS $file) {
	//для начала нам нада указать путь к файлу, чтобы можно было сделать объект нужного типа
	$file->file_path = $run['my_content'].'/'.$file->parentid.'/'.$file->fileid;
	$previewFile = $run['my_content'] .'/thumbs/'.$file->parentid.'/'.$file->fileid;
	//теперь генерируем превью
	$file->instance->GetPreview()->save($previewFile,'jpg',true);
	echo "Generated for {$previewFile} <br>";
}
exit;
?>