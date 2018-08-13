<?php
$uid = D::$req->int('uid');
$chatid = D::$req->int('chatid');
if($uid != 0 and $uid != D::$user->uid ) {
	$recipient = dFactory::dUser($uid);
	$T['chat'] = PrivateChat::getChatForRecepient(D::$user->uid, $uid);
	$T['recipient'] = $recipient;
}
?>