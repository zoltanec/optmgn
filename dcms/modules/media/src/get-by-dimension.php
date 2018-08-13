<?php
$dim = D::$req->select('dim', array_values(MediaDir::$additional_dimensions));
$ext = D::$req->select('ext', array('jpg','png','bmp','jpeg'));
$dir = dObject::MediaDir(D::$req->textID('dirid'));
if(!$dir) {
	throw new dRuntimeException('NO_SUCH_MEDIA_DIR');
}
$file = dObject::MediaFile(D::$req->textID('fileid').":::".$dir->dirid);
if(!$file) {
	throw new dRuntimeException('NO_SUCH_MEDIA_FILE');
}
$file = file_get_contents(D::$config->content_path."/media/".$dir->dirid."/".$dim."-".$file->fileid.".".$ext);
header("Content-Type: application/octet-stream");
header("Content-Length: ".strlen($file));
header("Content-Disposition: attachment; filename=\"Wallpaper.{$dim}.{$ext}\";");
header("Expires: 0");
header("Pragma: cache");
header("Cache-Control: private");
echo $file;
exit;
?>