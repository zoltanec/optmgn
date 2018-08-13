<?php
$module = D::$req->textID('module');
$path = D::getModulePath($module);
if(empty($path)) {
	throw new D_Core_Exception('Module not found');
}
if(!is_dir($path."/i18n")) {
	throw new D_Core_Exception("No i18n-directory found");
}

$T['files'] = [];


foreach(D_Core_Filesystem::getDirListing($path."/i18n") AS $file) {

	if($file['type'] == 'file' && preg_match('/(.*).lng/', $file['name'])) {
		$file_name = $path."/i18n/".$file['name'];
		$T['files'][$file_name] = Core_I18n_File::load($path."/i18n/".$file['name']);

	} elseif ( $file['type'] == 'dir') {
		foreach(D_Core_Filesystem::getDirListing($path."/i18n/".$file['name']) AS $subfile) {
			$file_name = $path."/i18n/".$file['name']."/".$subfile['name'];
			$T['files'][$file_name] = Core_I18n_File::load($file_name);
		}
	}
}
D::$tpl->clearCache();

if(D::$req->isAjax()) {
	D::$Tpl->PrintText('OK');
}
?>
