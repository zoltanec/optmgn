<?php
$newFileSource = D::$req->uploaded->files['upload_file'];

if ($newFileSource){
	copy($newFileSource, D::$path.'/content/images/'.$newFileSource->name);
}
	
$T['upfile'] = '/content/images/'.$newFileSource->name;

?>
