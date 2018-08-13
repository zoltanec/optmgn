<?php
$topic = D_Core_Factory::Forum_Topic(D::$req->intID('tid'));

if(D::$user and $topic->uid != D::$user->uid AND !D::$user->reqRights('edit/forum/forumtopic/')) {
	throw new D_Core_Exception(EX_ACCESS_DENIED);
}
$T['topic'] = &$topic;
?>