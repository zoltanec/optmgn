<?php
// check user authorization
if(!D::$user) {
	D::$Tpl->RedirectOrJSON("/users/enter/", array('status' => 'UNAUTH'));
}
try {
	$user = D_Core_Factory::D_Core_User(D::$user->uid);
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON( "/users/start-registration/", array('status' => 'NO_SUCH_USER'));
}
$url = D::$req->url('return');

if(!is_object($user) || !$user->isActive()) {
	D::$Tpl->RedirectOrJSON('/',array('status' => 'USER_INACTIVE'));
}
$content = trim(D::$req->bbText('content'));
// looks like we have no content
if(empty($content)) {
	D::$Tpl->RedirectOrJSON($url, array('status' => 'EMPTY_CONTENT'));
}
$comid = Comments_Comment::writeComment( array('object_id' => D::$req->textLine('object_id'), 'content' => $content, 'user' => &D::$user));
//увеличиваем счетчик сообщений пользователя
D::$user->messagesIncr();
try {
	$comment = D_Core_Factory::Comments_Comment($comid);
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON($url, array('status' => 'COMMENT_NOT_FOUND'));
}
if($comment->approved) {
	D::$Tpl->RedirectOrJSON($url."#commentN{$comid}", array('status' => 'OK'));
} else {
	D::$Tpl->RedirectOrJSON($url."#comment_wrapper", array('status' => 'APPROVE_NEEDED'));
}
?>