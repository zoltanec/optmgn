<?php
$currentdir=D::$req->textLine('current_dir');
$newFileSource = D::$req->uploaded->files['upload_file'];

if ($newFileSource){
	copy($newFileSource, $currentdir.'/'.$newFileSource->name);
}

D::$Tpl->Redirect('~/cd-dir/currentdir_'.base64_encode(urlencode($currentdir)));

?>
