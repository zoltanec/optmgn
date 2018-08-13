<?php
try {
	//Отображаем корневой каталог медиатеки
	$dir = $T['root'] = D_Core_Factory::Media_Dir('root');
} catch (Exception $e) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NOT_SUCH_DIRECTORY'));
}
D::$tpl->title = $dir->title;
D::$tpl->description = $dir->descr;
?>