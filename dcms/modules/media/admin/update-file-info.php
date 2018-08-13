<?php
$fileid = D::$req->textID('fileid');
$dirid = D::$req->textID('dirid');
$file = D_Core_Factory::Media_File($fileid.':::'.$dirid);
if(!$file) {
	D::$Tpl->redirect('~/');
}
if(true) {
	//$preview = D::$req->image('preview');

	//if( $preview = D::$req->image('preview') ) {
		//выполняем ресайз
	//	$preview->resize(120,120);
	//	$preview->save($run['my_content']."/thumbs/". $file->parentid ."/". $file->fileid,'jpg');
	//}

	D::$req->map($file, array('filename'=>'textLine', 'descr' => 'bbText','variants' => 'bbText'));
	//$newpath=D::$req->textLine('parentid');
	//if($newpath){
	//    exec('mv '.$run['my_content'].'/'.$file->parentid.'/'.$file->fileid.' '.$run['my_content'].'/'.$newpath.'/'.$file->fileid);
	//    exec('mv '.$run['my_content'].'/thumbs'.$file->parentid.'/'.$file->fileid.' '.$run['my_content'].'/thumbs'.$newpath.'/'.$file->fileid);
	//}
	$file->save();
	
} elseif (D::$req->flag('regeneratepreview')) {
	//для начала нам нада указать путь к файлу, чтобы можно было сделать объект нужного типа
	$file->file_path = $run['my_content'].'/'.$file->parentid.'/'.$file->fileid;
	//теперь генерируем превью
	$file->instance->GetPreview()->save($run['my_content'] .'/thumbs/'.$file->parentid.'/'.$file->fileid,'jpg',true);
}
echo "success";exit;
/**
if(D::$req->flag('update')) {
		$fileid = D::$req->textID('fileid');
		$dirid = D::$req->textID('dirid');
		$file = dObject::MediaFile($fileid.':::'.$dirid);
		if(!$file) {
			D::$Tpl->redirect('~/');
		}
		//перезаливка превью
		if( $preview = D::$req->image('preview') ) {
				//выполняем ресайз
				$preview->resize(120,120);
				$preview->save($run['my_content']."/thumbs/". $dir->dirid ."/". $fileid,'png');
		}
			//перезаливка файла
			/*$newFile = D::$req->uploaded->files['newfile'];
			if( $newFile = D::$req->uploaded->files['newfile'] ) {
				$files = new MediaFile();
				$newFile->saveas(D::$content_path."/media/".$dirid."/".$fileid);
				$obj = $files->Build(D::$content_path."/media/".$dirid."/".$fileid);
				$obj->getPreview(D::$content_path."/media/".$dirid."/".$fileid, $fileid, $dirid);
				$obj->save($filename,$fileid, $dirid);
			}
			$file->fileid($fileid)->filename($fileid)->parentid($dirid);
		} else {
			trigger_error("Trying to upload file for non existed directory: {$dirid}.");
			D::$Tpl->redirect("~/");
		}
	D::$req->map($file, array('fileid'=>'textLine','filename'=>'textLine','active'=>'bool'));
	$file->save();
	D::$Tpl->redirect("~/ls/dir_{$dirid}/");
	//перенаправляем пользователя
}
//изменение каталога файла
if(D::$req->flag('updatedir')) {
	$fileid = D::$req->textID('fileid');
	$dirid = D::$req->textID('dirid');
	$newdirid = $_POST['parentid'];
	$file = new MediaFile($fileid);
	$file->ChangeDir($dirid,$newdirid,$fileid);
	D::$Tpl->redirect("~/ls/dir_{$dirid}/");
}
//добавляем водяной знак
if(D::$req->flag('addwatermark')) {
	$fileid = D::$req->textID('fileid');
	$dirid = D::$req->textID('dirid');
	$mainimg = file_get_contents(D::$content_path."/media/".$dirid."/".$fileid);
	$im = imagecreatefromstring($mainimg);
	$watermark = file_get_contents(D::$content_path."/media/watermark/". $dirid .".png");
	$watermark = imagecreatefromstring($watermark);
	$image = MediaFile::picture_watermark($im,$watermark,60);
	imagejpeg($image,D::$content_path."/media/".$dirid."/".$fileid);
	D::$Tpl->redirect("~/ls/dir_{$dirid}/");
}*/
?>