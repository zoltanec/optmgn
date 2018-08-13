<?php
$module_path = D::getModulePath(D::$req->textID('param3'));
if(empty($module_path)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/',array('status' => 'ERROR_NO_SUCH_MODULE'));
}
$file = $module_path."/install/structure.sql";
if(!is_file($file)) {
	D::$Tpl->RedirectOrJSON('~/list-modules/err_NO_SUCH_SQL_FILE', array('status' => 'ERROR_NO_SUCH_SQL_FILE'));
}

$sql_file = file_get_contents($file);

foreach(explode("\n--",$sql_file) AS $command) {

	if(!empty($command)) {
		D::$db->exec($command);
	}

}
D::$Tpl->RedirectOrJSON('~/list-modules/',array('status' => 'OK'));
?>
