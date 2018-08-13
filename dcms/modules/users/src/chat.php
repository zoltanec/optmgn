<?php
if(!D::$user) {
	D::$Tpl->RedirectOrText('~/enter/','UNAUTH');
}

$uid = D::$req->int('uid');
$chatid = D::$req->int('chatid');

if($uid != 0 and $uid != D::$user->uid ) {
	$recipient =D_Core_Factory::Users_User($uid);
	$T['chat'] = Users_Private_Chats::getChatForRecepient(D::$user->uid, $uid);
	$T['recipient'] = $recipient;

	if($T['chat']) {
		$T['chat']->setChatReaded();
		// список сообщений
		$T['messages'] = $T['chat']->messages_list;
		// указываем номер страницы запрошенной пользователем
		if(D::$req->raw('param2') != '') {
			$T['messages']->page = D::$req->page('param2');
		} else {
			$T['messages']->page = D::$req->page('page');
		}
		$T['messages']->perpage(40);
	}

	D::$tpl->title = D::$i18n->getTranslation('PRIVATE_CHAT_WITH')." ".$recipient->username;

	if(D::$req->textLine('mode') == 'latest') {
		if(is_object($T['chat'])) {
			$T['chat']->setMinMsgid(D::$req->int('last_msgid'));
			D::$tpl->RenderTpl('render-chat');
		} else {
			D::$tpl->PrintText('');
		}
	} elseif(D::$req->isAjax() && D::$req->textLine('mode') == 'get-page' ) {
		D::$tpl->RenderTpl('chat-messages-page');
	}
}
?>