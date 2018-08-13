<?php
$dir = D::$req->url('dir');
if(!$dir) {
	$dir_path = D::$config->content_path;
} else {
	$dir_path = urldecode(base64_decode($dir));
}
// удаляем из пути переходы на верхний каталог
$dir_path = preg_replace('/\.\.\//','',$dir_path);
// если вдруг пользователь попытался выбраться за пределы разрешенного каталога контента то даем ему по рукам
if(strlen($dir_path) < strlen(D::$config->content_path) ) {
	$dir_path = D::$config->content_path;
}
if(!is_dir($dir_path)) {
	$dir_path = D::$config->content_path;
}
$T['dir']=new File($dir_path);
D::$Tpl->RenderTpl('filemanager;admin/list.tpl');
?>