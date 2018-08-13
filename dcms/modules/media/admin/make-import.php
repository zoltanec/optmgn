<?php
$SEPARATOR = '_SEPARATOR_';
$parentid = D::$req->textID('parentid');
try {
	$mediadir = D_Core_Factory::Media_Dir($parentid);
} catch (Exception $e) {
	D::$Tpl->Redirect('~/');
}
if(!$mediadir) {
	D::$Tpl->redirect('~/errmsg_no-such-dir/');
}
$dir = $_POST['importdir'];

$priority = $mediadir->files_count;

for($j = 0; $j < count($dir); $j++) {
	$dir[$j] = str_replace($SEPARATOR, '/', $dir[$j]);
	$files = Media_Dir::ScanDir($run['my_content'].'/upload/'.$dir[$j]);
	//сортируем файлики по порядку
	sort($files,SORT_STRING);
	for($k = 0; $k < count($files); $k++) {
		//имя исходного файла
		$sourceFile = $files[$k];
		echo $sourceFile."<br>";
		$filename = addslashes(basename($sourceFile));
		$media_file = new Media_File();
		//файл будет инициирован из медиафайла
		$media_file->parentid($mediadir->dirid)->from($sourceFile)->priority($priority);
		$media_file->saveConverted();
		$media_file->saveThumb();
		$media_file->save();
		if($media_file->type == 'unknown') {
			echo "File skipped : {$sourceFile}.";
			continue;
		}
		
		//$MediaFile->instance->cutImage($MediaFile->instance->size_x,$MediaFile->instance->size_y-200)->save($run['my_content'] .'/'.$mediadir->dirid.'/'.$MediaFile->fileid,'jpg',true);
		
		//$previewPath = $run['my_content'] .'/thumbs/'.$mediadir->dirid.'/'.$MediaFile->fileid;
		//$MediaFile->instance->GetPreview()->save($run['my_content'] .'/thumbs/'.$mediadir->dirid.'/'.$MediaFile->fileid,'jpg',true);
		//если не смогли сделать превьюху, то юзает картинку каталога
		//if(!file_exists($previewPath)) {
		//	@copy($run['my_content'].'/dir_preview/'.$mediadir->dirid.'.png', $previewPath);
		//}
		//$sourceFile_substrings=explode('/',$sourceFile);
		//$MediaFile->descr=iconv("windows-1251", "utf-8", str_replace('.jpg','',end($sourceFile_substrings)));
		//$MediaFile->save();
		$priority += 1;
	}
}
$mediadir->rebuildDirStat();
echo "<a href='{$run['me']}/index/dir_".$mediadir->dirid."'>Перейти в каталог</a>";
exit;
?>