<?php

// Путь к теме модуля.

$module = D::$req->textID('param3');
$theme_module_path = D::getModulePath($module)."/theme/";

// Путь к теме сайта, если тема не установлена в конфиге $cfg['theme'] то тема default !
$theme_site_path = D::$config->theme_dir;

if(!file_exists($theme_site_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_THEMES_IN_SITE/', array('status' => 'ERROR_NO_THEMES_IN_SITE'));
}

if(empty($theme_module_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_SUCH_MODULE/', array('status' => 'ERROR_NO_SUCH_MODULE'));
}

foreach(D::$tpl->getThemesList() AS $theme) {
	$theme_site_path = D::$config->themes_dir.'/'.$theme;

	if(!is_writable($theme_site_path)) {
		D::$Tpl->RedirectOrJSON('~/list-modules/err_THEMES_PERMISSION_DENIED', array('status' => 'ERROR_THEMES_PERMISSION_DENIED'));
	}

	if(!file_exists($theme_module_path)) {
		D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_THEME_IN_MODULE/', array('status' => 'ERROR_NO_THEME_IN_MODULE'));
	}

	$theme_site_path .= '/'.$module;

	$dbgout = D_Core_Filesystem::link_files($theme_module_path, $theme_site_path, true, true);
}
foreach($dbgout as $val) {
	Core_Debug::dprint($val);
}

Core_Debug::dprint("<br><a href='/admin/run/core/list-modules/'>go back</a>");

Core_Debug::dbg_render();

?>
