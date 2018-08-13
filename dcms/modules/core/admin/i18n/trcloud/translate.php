<?php
header("Content-type: text/html; charset=UTF-8");
$cloud = new Core_I18n_Trcloud(D::$config->{'core.i18n.trcloud.key'});


echo $cloud->request("2 step", 'en', 'ru');
//exit;

foreach(D::$config->languages AS $lang) {
	$text = $cloud->request("3 step", 'en', $lang);
	if(empty($text)) continue;

	$msg = new Core_I18n_Message();
	$msg->lang = $lang;
	$msg->msg_text =$text;
	$msg->msg_code = "LP_STEP_3";
	$msg->save();

	echo "{$lang}:{$text}\n";
}
exit;

foreach(Account_SubscribeType::all() AS $country) {
	if($country->sid != D::$req->int('sid')) continue;
	//echo $country->subscribe_name;
	foreach(D::$config->languages AS $lang) {
		if($lang == 'en') continue;

		echo $country->subscribe_name;
		echo "\n{$lang}\n\n";

		$tr = $cloud->request($country->subscribe_name, 'en', $lang);
		if(empty($tr)) continue;

		$msg = new Core_I18n_Message();
		$msg->lang = $lang;
		$msg->msg_text = $cloud->request($country->subscribe_name, 'en', $lang);
		$msg->msg_code = $country->subscribe_name;
		$msg->save();
	}
}
//
//echo htmlspecialchars($cloud->request('Наши сервера расположены во многих странах мира, что позволяет вам получить доступ практически к любым ресурсам, доступ к которым был закрыт ранее.
//', 'ru', 'de'));
exit;