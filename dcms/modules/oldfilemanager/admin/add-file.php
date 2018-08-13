<?php
$currentdir=D::$req->textLine('dir');
$newFileSource = D::$req->uploaded->files['file']->tmp_name;
var_dump($newFileSource);exit;
if ($newFileSource){
	copy($newFileSource, $currentdir.'/'.$newFileSource->name);
}
D::$Tpl->Redirect('~/cd-dir/currentdir_'.base64_encode(urlencode($currentdir)));
?>