<?php
$dirid = D::$req->textID('dir');
//Если корневая дирректория, то перемещаем в начало
if($dirid == 'root') {
	D::$Tpl->Redirect('~/');
}

try {
	$dir = D_Core_Factory::Media_Dir($dirid);
} catch ( Exception $e ) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NOT_SUCH_DIRECTORY'));
}

if(count($dir->subdirs) == 0 && empty($dir->template)) {
	// проверяем есть ли у нас вообще файлы
	if(sizeof($dir->files) > 0 ) {
		$firstfile = $dir->files[0];
		// а теперь перенаправляем на первый
		//D::$Tpl->Redirect('~/show/' . $dir->dirid . "/" . $firstfile->fileid);
	} else {
		D::$tpl->Redirect('~/ls/dir_' . $dir->parentid . "/");
	}
}
//Bread crumbs
//$dir->setBreadCrumbs();
$T['current_dir'] = &$dir;
//проверяем что нам не нужно отдельный шаблон
if($dir->template != '') {
	D::$tpl->show($dir->template);
}
D::$tpl->title = $dir->title;
D::$tpl->description = $dir->descr;
?>