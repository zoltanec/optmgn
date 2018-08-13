<?php
$topic = D_Core_Factory::Forum_Topic(D::$req->int('tid'));

if($topic->uid != D::$user->uid AND !D::$user->reqRights('edit/forum/forumtopic')) {
	throw new D_Core_Exception(EX_ACCESS_DENIED);
}
D::$req->map($topic, array('title' => 'textLine', 'descr' => 'textLine'));
$topic->content = D::$req->bbText('content');
$topic->save();
D::$tpl->Redirect('~/edit-topic/tid_'.$topic->tid.'/okmsg_topic-updated/');
?>