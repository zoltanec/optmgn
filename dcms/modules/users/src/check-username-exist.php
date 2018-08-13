<?php
$username = D::$req->textLine('username');
if(dUser::isUsernameExists($username)) {
	D::$Tpl->PrintText('OK_USED');
} else {
	D::$Tpl->PrintText('OK_FREE');
}
?>