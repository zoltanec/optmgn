<?php

//определяем какой модуль нам необходим
$module = D::$req->textID('param1');
$action = D::$req->textID('param2');

$modulePath = D::getModulePath($module);
//подключаем инициализацию
if(file_exists($modulePath."/admin/init.php")) {
	require_once $modulePath."/admin/init.php";
}

$action = str_replace('.', '/', $action);

$T['run'] = $_TPL['run'] = array('me' => D::$web."/admin/run/".$module, 
'my_content'  => D::$content."/".$module, 
'admin'  => D::$web."/admin/run",
'module'  => $module, 
'action'  => $action, 
'path'  => D::$web."/".$module);
//основные переменные необходимые модулю
$run = array(
'me' => D::$web."/admin/run/".$module, 
'my_content' => D::$content_path."/".$module, 
'path'=>D::$modules_path."/".$module, 
'webpath' => D::$web."/".$module);

//указываем путь для инклуда
if(!$action) {
	if(isset($default_admin_action)) {
		$action = $default_admin_action;
	} else {
		$action = 'index';
	}
}

// добавляем пространство модуля без этого не работает
D::appendModuleNamespace($module);
// путь автозагрузки
if(!file_exists($modulePath."/admin/{$action}.php")) {
	throw new D_Core_Exception("Admin action {$action} not found", EX_OTHER_ERROR);
}
//указываем базу для редиректа
D::$Tpl->redirect_base = "/admin/run/".$module;
// add bread crumb
D::$tpl->addBC('~/index/', D::$i18n->getTranslation($module.'_MODULE_NAME'));
require_once $modulePath."/admin/{$action}.php";
$requested_action = $action;
$T['module_toolbar'] = "{$module};admin/toolbar.tpl";
$T['run_template'] = "{$module};admin/{$requested_action}.tpl";
if(D::$req->isAjax()) {
	D::$Tpl->renderTpl("admin/".$requested_action);
} else {
	D::$Tpl->show('run.tpl');
}
D::finishRequest();
?>