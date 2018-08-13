<?php
header("Content-type: text/html; charset=UTF-8");
$cloud = new Core_I18n_Trcloud(D::$config->{'core.i18n.trcloud.key'});

echo $cloud->request("Try it for free.", 'en', 'ru');
exit;

foreach(Account_SubscribeType::all() AS $country) {
	//echo $country->subscribe_name;
	foreach(D::$config->languages AS $lang) {
		if($lang == 'en') continue;

		echo $country->subscribe_name;
		echo "\n{$lang}\n\n";
		$msg = new Core_I18n_Message();
		$msg->lang = $lang;
		$msg->msg_text = $cloud->request($country->subscribe_name, 'en', $lang);
		$msg->msg_code = $country->subscribe_name;
		$msg->save();
	}
}
exit;