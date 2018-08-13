<?php
$setting_id = D::$req->textID('setting_id');
try {
	$setting = D_Core_Factory::Settings($setting_id);
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_SETTING'));
}
$setting_value = D_Core_Factory::SettingValue($setting_id);
$setting_value->value = $setting->parseValue(D::$req->textLine('value'));
var_dump($_REQUEST);
exit;
?>