<?php
if(D::$req->int('firstfile')==1)
{
	rmdir(D::$content_path.'/media/thumbs/'.$dir->dirid);
	rmdir(D::$content_path.'/media/'.$dir->dirid);
}
$dirid = D::$req->textLine('dir');
//загружаем каталог с которым мы хотим работать
$dir = D_Core_Factory::MediaDir($dirid);
//найден ли каталог в который будем добавлять
if(!$dir) {
	echo "error";exit;
}

//найден ли файл
if(!isset(D::$req->uploaded->files['file'])) {
	echo "error";exit;
}
$newFileSource = D::$req->uploaded->files['file'];
$MediaFile = new MediaFile();
//теперь загружаем
$MediaFile->parentid($dir->dirid)->from($newFileSource, $newFileSource->getExt())->fileid( $MediaFile->ReplaceToMyMeta( $dir->file_naming) )->filename($MediaFile->ReplaceToMyMeta( $dir->naming) );
$MediaFile->SaveConverted(D::$content_path.'/media/#parentid#/'.$MediaFile->fileid);
$MediaFile->instance->GetPreview()->save(D::$content_path.'/media/thumbs/'.$dir->dirid.'/'.$MediaFile->fileid,'jpg',true);
$MediaFile->save();
echo "success";exit;
?>