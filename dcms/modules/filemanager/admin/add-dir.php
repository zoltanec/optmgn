<?php
$dirname=D::$req->textLine('new_dir');
$currentdir=D::$req->textLine('current_dir');
mkdir($currentdir.'/'.$dirname);
D::$Tpl->Redirect('~/cd-dir/currentdir_'.base64_encode(urlencode($currentdir)));
//D::$Tpl->Redirect(D::$req->referer());
?>
