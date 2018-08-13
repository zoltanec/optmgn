<?php
$id = D::$config->{'loginza.id'};
$secret = D::$config->{'loginza.secret'};
if(empty($id) || empty($secret)) {
	D::$tpl->RedirectOrJSON('~/auth-error/err_no-loginza-not-configured/', ['status' => 'ERROR']);
}

$token = D::$req->textID('token');
$sign = md5($token.$secret);

$data = D_Misc_Url::FetchDocument("http://loginza.ru/api/authinfo?token={$token}&id={$id}&sig={$sign}");
$auth_data = json_decode($data);

if(!is_object($auth_data) || !isset($auth_data->identity)) {
	D::$tpl->Redirect('~/auth-error/err_wrong-token/');
}
try {
	$user = D_Core_Factory::Users_User($auth_data->identity);
} catch (Exception $e) {
	// create new user
	$user = new D_Core_User();
	//	заносим поля
	$user->username = $auth_data->identity;
	$user->setPassword(md5(rand()));
	$user->save();
}
D::$tpl->Redirect('~/auth-ok/');
?>
