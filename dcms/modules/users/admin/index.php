<?php
$T['userslist'] = Users_User::getUsersList(array('mode' => D::$req->select('mode', array('all','banned'))));
$T['userslist']->page = D::$req->intID('page');
?>