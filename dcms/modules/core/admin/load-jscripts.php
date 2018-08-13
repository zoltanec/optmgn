<?php


$module = D::$req->textID('param3');
$js_module_path = D::getModulePath($module)."/jscripts/";
$js_site_path = D::$config->jscripts_dir."/";

if(!is_writable(D::$config->jscripts_dir)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_JSCRIPTS_PERMISSION_DENIED', array('status' => 'ERROR_JSCRIPTS_PERMISSION_DENIED'));
}
if(empty($js_module_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_SUCH_MODULE/', array('status' => 'ERROR_NO_SUCH_MODULE'));
}

if(!file_exists($js_module_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_JSCRIPTS_DIRECTORY_IN_MODULE/', array('status' => 'ERROR_NO_JSCRIPTS_DIRECTORY_IN_MODULE'));
}

if(!file_exists($js_site_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_JSCRIPTS_DIRECTORY_IN_SITE/', array('status' => 'ERROR_NO_JSCRIPTS_DIRECTORY_IN_SITE'));
}

$dbgout = D_Core_Filesystem::link_files(D::$dcms_path."/jscripts/",$js_site_path,true);
$dbgout1 = D_Core_Filesystem::link_files($js_module_path,$js_site_path,true);

$dbgall = array_merge($dbgout,$dbgout1);

foreach($dbgall as $val) {
	Core_Debug::dprint($val);	
}

Core_Debug::dprint("<br><a href='/admin/run/core/list-modules/'>go back</a>");

Core_Debug::dbg_render();

//D::$Tpl->RedirectOrJSON('~/list-modules/', array('status' => 'OK'));




?>