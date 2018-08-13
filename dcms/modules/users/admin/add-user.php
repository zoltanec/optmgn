<?php
$user = new Users_User();
$user->save();
D::$tpl->Redirect('~/edit-user/uid_'.$user->uid);
?>