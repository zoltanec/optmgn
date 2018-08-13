<?php
$dir = D::$content_path."/users/avatars/defaults/";
$listing = D_Core_Filesystem::getDirListing($dir,false);
//var_dump($listing);exit;
// теперь формируем список
$dirs = array('other' => array('name' => D::$i18n->translate('USERS_AVATARS_OTHERS'),
                               'files' => array()));
foreach($listing AS $file) {
	if($file['type'] == 'file') {
		$dirs['other']['files'][] = array('name' => $file['name']);
	} elseif ($file['type'] == 'dir') {
		$subfiles = D_Core_Filesystem::getDirListing($dir."/".$file['name'],true);
		if(sizeof($subfiles) > 0 ) {
			$dirs[$file['name']] = array('name' => D::$i18n->translate('USERS_AVATARS_DIR_'.strtoupper($file['name'])), 'files' => array());
			foreach($subfiles AS $subfile) {
				$dirs[$file['name']]['files'][] = array('name' => $file['name']."/".$subfile['name']);
			}
		}
	}
}
$T['images'] = &$dirs;
?>