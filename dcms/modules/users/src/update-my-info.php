<?php
if(D::$user) {
	D::$req->map(D::$user, array('about' => 'bbText', 'skype' => 'textLine',
	                             'name' => 'textLine', 'phone' => 'textLine', 'birth_privacy' => 'bool',
	                             'interests' => 'textLine', 'user_from' => 'textLine', 'sign' => 'textLine',
	                             'icq' => 'textLine'));
	D::$user->birth = D::$req->datetime('birth')->format('%Y-%m-%d');
	D::$user->sex = D::$req->select('sex', array('M','W'));
	//убираем лишние символы из номера телефона
	D::$user->phone = preg_replace('/[^0-9+]/', '', D::$user->phone);
	if(!empty(D::$user->phone) AND !empty(D::$user->name) AND D::$req->bool('subscribe')) {
		D::$user->subscribe = true;
	} else {
		D::$user->subscribe = false;
	}
    D::$user->save();
    D::$Tpl->redirect("~/me/");
} else D::$Tpl->redirect("~/enter/");
?>