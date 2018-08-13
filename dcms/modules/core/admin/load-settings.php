<?php
$module = D::$req->textID('param3');
$path = D::getModulePath($module);
if(empty($path)) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_MODULE'));
}
$file_path = $path."/install/settings.json";
if(!file_exists($file_path)) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SETTINGS_FILE'));
}
$content = preg_replace("/#(.*)\n/","",file_get_contents($file_path));
$settings_content = json_decode($content);
if($settings_content == NULL || !is_array($settings_content)) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_WRONG_SETTINGS_FILE'));
}
$imported = array();
foreach($settings_content AS $setting) {
	$setting->setting_id = 'site.'.$module.'.'.$setting->id;
	$new_setting = new Settings();
	$new_setting->importFromObject($setting);
	$new_setting->save();
	$new_setting->createDefault();
	$imported[] = $new_setting->setting_id;
}
D::$Tpl->PrintJSON($imported);
?>